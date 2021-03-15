<?php

namespace App\Controller;

use App\Entity\ShoppingList;
use App\Entity\ShoppingListProduct;
use App\Form\ShoppingListProductType;
use App\Form\ShoppingListType;
use App\Repository\ShoppingListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ShoppingListController extends AbstractController
{
    /**
     * @param ShoppingListRepository $shoppingListRepository
     * @param Request $request
     * @Route("/", name="shopping_list_index", methods={"GET","POST"})
     * @return Response
     */
    public function index(ShoppingListRepository $shoppingListRepository, Request $request): Response
    {
        $shoppingList = new ShoppingList();
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shoppingList);
            $entityManager->flush();

            return $this->redirectToRoute('shopping_list_index');
        }

        return $this->render('shopping_list/index.html.twig', [
            'shopping_lists' => $shoppingListRepository->findBy(array(),array('id'=>'ASC')),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="shopping_list_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shoppingList = new ShoppingList();
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shoppingList);
            $entityManager->flush();

            return $this->redirectToRoute('shopping_list_index');
        }

        return $this->render('shopping_list/new.html.twig', [
            'shopping_list' => $shoppingList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shopping_list_show", methods={"GET"})
     */
    public function show(ShoppingList $shoppingList): Response
    {
        return $this->render('shopping_list/show.html.twig', [
            'shopping_list' => $shoppingList,
        ]);
    }

    /**
     * @param ShoppingListProduct $shoppingListProduct
     * @param ShoppingList $shoppingList
     * @param Request $request
     * @Route("/add/product/{id}", name="add_product", methods={"GET","POST"})
     * @return Response
     */
    public function add(ShoppingListProduct $shoppingListProduct, ShoppingList $shoppingList, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ShoppingListProductType::class, $shoppingListProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            //return $this->redirectToRoute('add_product');
        }

        $lists = $em->getRepository('App:ShoppingListProduct')->findBy(array(
            'shopping_list' => $shoppingList
        ));

        return $this->render('shopping_list/add_product.html.twig', [
            'shopping_list' => $shoppingList,
            'lists' => $lists,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shopping_list_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ShoppingList $shoppingList): Response
    {
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shopping_list_index');
        }

        return $this->render('shopping_list/edit.html.twig', [
            'shopping_list' => $shoppingList,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="shopping_list_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ShoppingList $shoppingList): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $shoppingListProductEntity = $entityManager->getRepository('App:ShoppingListProduct');
        $shoppingListProducts =  $shoppingListProductEntity->findBy(array('shopping_list' => $shoppingList));
        foreach ($shoppingListProducts as $shoppingListProduct) {
            $list = $shoppingListProductEntity->find($shoppingListProduct->getId());
            $shoppingList->removeShoppingListProduct($list);
            $entityManager->remove($list);
        }
        if ($this->isCsrfTokenValid('delete'.$shoppingList->getId(), $request->request->get('_token'))) {
            $entityManager->remove($shoppingList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shopping_list_index');
    }
}
