<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @Route("/", name="category_index", methods={"GET","POST"})
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succés!');

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @Route("/new", name="category_new", methods={"GET","POST"})
     * @return Response
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Category $category
     * @Route("/{id}", name="category_show", methods={"GET"})
     * @return Response
     */
    public function show(Category $category): Response
    {
        $products = $category->getProducts()->getValues();
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     * @return Response
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     * @return Response
     */
    public function delete(Request $request, Category $category): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $category->getProducts();
        if(count($products) > 0) {
            throw new \Exception('Erreur ! Des produits sont rattachés à cette catégorie');
        } else {
            if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
                $entityManager->remove($category);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('category_index');
    }
}
