<?php

namespace App\Service;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;

class ChartsManager
{
    public function __construct(private readonly OrderRepository $orderRepository,
        private readonly ProductRepository $productRepository,
        private readonly UserRepository $userRepository)
    {
    }

    public function getCountsDatas(): array
    {
        $data = [];
        $data['user'] = count($this->userRepository->findAll());
        $data['product'] = count($this->productRepository->findAll());
        $data['order'] = count($this->orderRepository->findAll());

        return $data;
    }

    public function countNewUser(): float|array|int|string
    {
        return $this->userRepository->countNewUserPerDay();
    }
}
