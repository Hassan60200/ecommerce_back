<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\ChartsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
//#[IsGranted("ROLE_ADMIN")]
class AdminController extends AbstractController
{
    public function __construct(private readonly ChartsManager $chartsManager, private readonly ProductRepository $productRepository)
    {
    }

    #[Route('/', name: 'app_admin', methods: "GET")]
    public function index(): Response
    {
      $data = $this->chartsManager->getCountsDatas();

       return new JsonResponse($data, 200);
    }

    #[Route('/products', name: 'app_admin_products', methods: "GET")]
    public function indexProduct(): Response
    {
        $product= $this->productRepository->findAll();

        return new JsonResponse($product, 200);
    }
}
