<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\ChartsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(private readonly ChartsManager $chartsManager, private readonly ProductRepository $productRepository, private readonly EntityManagerInterface $manager, private readonly CategoryRepository $categoryRepository)
    {
    }

    #[Route('/', name: 'app_admin', methods: 'GET')]
    public function index(): Response
    {
        $data = [];
        $data['stats'] = $this->chartsManager->getCountsDatas();
        $data['chartsUsers'] = $this->chartsManager->countNewUser();

        return new JsonResponse($data, 200);
    }

}
