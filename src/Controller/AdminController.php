<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\ChartsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(private readonly ChartsManager $chartsManager, private readonly ProductRepository $productRepository, private readonly EntityManagerInterface $manager, private readonly CategoryRepository $categoryRepository)
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
        $product = $this->productRepository->getAllProducts();

        return new JsonResponse($product, 200);
    }

    #[Route('/product/new', name: 'admin_add_product', methods: "POST")]
    public function newProduct(Request $request): Response
    {
        $content = json_decode($request->getContent());
        $product = new Product();
        $product->setTitle($content->title)
            ->setDescription($content->description)
            ->setCategory($this->categoryRepository->find($content->category_id))
            ->setWeight($content->weight)
            ->setPrice($content->price)
            ->setIsBest($content->isBest)
            ->setIsAvailaible($content->isAvailaible);

        $this->manager->persist($product);
        $this->manager->flush();

        return new JsonResponse('Un nouveau produit a été ajouté', 200);
    }

    #[Route('/product/edit/{id}', name: 'admin_edit_product', methods: "PUT")]
    public function editProduct(Request $request): Response
    {
        $content = json_decode($request->getContent());
        $product = new Product();
        $product->setTitle($content->title)
            ->setDescription($content->description)
            ->setCategory($this->categoryRepository->find($content->category_id))
            ->setWeight($content->weight)
            ->setPrice($content->price)
            ->setIsBest($content->isBest)
            ->setIsAvailaible($content->isAvailaible);

        $this->manager->persist($product);
        $this->manager->flush();

        return new JsonResponse('Un nouveau produit a été ajouté', 200);
    }

    #[Route('/product/delete/{id}', name: 'admin_delete_product', methods: "DELETE")]
    public function deleteProduct(Request $request): Response
    {
        $content = json_decode($request->getContent());
        $product = new Product();
        $product->setTitle($content->title)
            ->setDescription($content->description)
            ->setCategory($this->categoryRepository->find($content->category_id))
            ->setWeight($content->weight)
            ->setPrice($content->price)
            ->setIsBest($content->isBest)
            ->setIsAvailaible($content->isAvailaible);

        $this->manager->persist($product);
        $this->manager->flush();

        return new JsonResponse('Un nouveau produit a été ajouté', 200);
    }
}
