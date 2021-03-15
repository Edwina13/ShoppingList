<?php

namespace App\Controller;

use App\Entity\ShoppingListProduct;
use App\Form\ShoppingListProductType;
use App\Repository\ShoppingListProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopping/list")
 */
class ShoppingListProductController extends AbstractController
{
    /**
     * @param ShoppingListProductRepository $shoppingListProductRepository
     * @Route("/", name="shopping_list_product_index", methods={"GET"})
     * @return Response
     */
    public function index(ShoppingListProductRepository $shoppingListProductRepository): Response
    {
        return $this->render('shopping_list_product/index.html.twig');
    }

    /**
     * @Route("/{id}/add", name="add_shopping_list_product", methods={"GET","POST"})
     * @throws \Exception
     */
    public function add(Request $request): Response
    {
        $shoppingListProduct = new ShoppingListProduct();
        $form = $this->createForm(ShoppingListProductType::class, $shoppingListProduct);
        $form->handleRequest($request);

        $listId = intval($request->get('id'));
        $em = $this->getDoctrine()->getManager();
        $listEntity = $em->getRepository('App:ShoppingListProduct');
        $lists = $listEntity->findby(array('shopping_list' => $listId));
        $shoppingList = $em->getRepository('App:ShoppingList')->find($listId);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $productId = $shoppingListProduct->getProduct()->getId();
            $checkExists = $listEntity->findOneBy(array('shopping_list' => $listId, 'product' => $productId));
            if (is_null($checkExists)) {
                $shoppingListProduct->setShoppingList($shoppingList);
                $entityManager->persist($shoppingListProduct);
                $entityManager->flush();
                $this->addFlash('success', 'Produit bien ajouté à la liste');
            } else {
                throw new \Exception('Erreur! Ce produit est déjà présent dans la liste');
            }
            return $this->redirect($request->getUri());
        }

        return $this->render('shopping_list_product/new.html.twig', [
            'shopping_list_product' => $shoppingListProduct,
            'form' => $form->createView(),
            'lists' => $lists,
            'shoppingList' => $shoppingList
        ]);
    }

    /**
     * @Route("/{id}", name="shopping_list_product_show", methods={"GET"})
     */
    public function show(ShoppingListProduct $shoppingListProduct): Response
    {
        return $this->render('shopping_list_product/show.html.twig', [
            'shopping_list_product' => $shoppingListProduct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shopping_list_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ShoppingListProduct $shoppingListProduct): Response
    {
        //$previousUrl = $request->headers->get('referer');
        $this->get('session')->set('url', $request->headers->get('referer'));
        $form = $this->createForm(ShoppingListProductType::class, $shoppingListProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('add_shopping_list_product', array('id'=>$shoppingListProduct->getShoppingList()->getId()));
        }

        return $this->render('shopping_list_product/edit.html.twig', [
            'shopping_list_product' => $shoppingListProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shopping_list_product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ShoppingListProduct $shoppingListProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shoppingListProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shoppingListProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('add_shopping_list_product', array('id'=>$shoppingListProduct->getShoppingList()->getId()));
    }
}
