<?php

namespace App\Service;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChartsManager
{
    public function __construct(private readonly OrderRepository   $orderRepository,
                                private readonly ProductRepository $productRepository,
                                private readonly UserRepository    $userRepository)
    {

    }

    public function getCountsDatas()
    {
        $data = [];
        $data['user'] = count($this->userRepository->findAll());
        $data['product'] = count($this->productRepository->findAll());
        $data['order'] = count($this->orderRepository->findAll());

        return $data;
    }
}