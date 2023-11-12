<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/api/search/products', name: 'search_products', methods: "GET")]
    public function search(Request $request, ProductRepository $productRepository): Response
    {
        $searchValue = $request->query->get('query');
        $products = $productRepository->searchProduct($searchValue);

        return $this->json($products);
    }
}
