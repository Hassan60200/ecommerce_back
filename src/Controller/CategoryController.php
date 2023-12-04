<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_category')]
    public function category_index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->getAllCategories();
        return new JsonResponse($categories, 200);
    }

    #[Route('/category/{id}', name: 'app_category_show', methods: 'GET')]
    public function show(ProductRepository $productRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $category = $categoryRepository->find($request->attributes->get('id'));
        $productByCategory = $productRepository->searchByCategory($category->getName());
        return new JsonResponse($productByCategory, 200);
    }
}
