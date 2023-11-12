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
        $nameValue = $request->query->get('name');
        $categoryValue = $request->query->get('category');
        $products = '';
        if (!is_null($nameValue)) {
            $products = $productRepository->searchProduct($nameValue);
        }elseif (!is_null($categoryValue)){
            $products = $productRepository->searchByCategory($categoryValue);
        }

        return $this->json($products);
    }

}
