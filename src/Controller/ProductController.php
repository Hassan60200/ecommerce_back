<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products')]
class ProductController extends AbstractController
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    #[Route('/', name: 'product_index', methods: "GET")]
    public function index(): JsonResponse
    {

        $products = $this->productRepository->getProductIsAvailaible();

        return new JsonResponse($products, 200);
    }

    #[Route('/search/', name: 'search_products', methods: "GET")]
    public function search(Request $request, ProductRepository $productRepository): Response
    {
        $nameValue = $request->query->get('name');
        $categoryValue = $request->query->get('category');
        $products = '';
        if (!is_null($nameValue)) {
            $products = $productRepository->searchProduct($nameValue);
        } elseif (!is_null($categoryValue)) {
            $products = $productRepository->searchByCategory($categoryValue);
        }

        return $this->json($products);
    }

}
