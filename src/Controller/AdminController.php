<?php

namespace App\Controller;

use App\Entity\Category;
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

//#[Route('/admin')]
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

    #[Route('/products', name: 'app_admin_products', methods: 'GET')]
    public function indexProduct(): Response
    {
        $product = $this->productRepository->getAllProducts();

        if (!$product) {
            return new JsonResponse('Not product found', 404);
        }

        return new JsonResponse($product, 200);
    }

    #[Route('/product/{id}', name: 'admin_show_product', methods: 'GET')]
    public function productShow($id): JsonResponse
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);

        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], 404);
        }

        return new JsonResponse($product, 200);
    }

    #[Route('/product/new', name: 'admin_add_product', methods: 'POST')]
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

    #[Route('/product/edit/{id}', name: 'admin_edit_product', methods: 'PUT')]
    public function editProduct(Request $request): Response
    {
        $content = json_decode($request->getContent());
        $product = $this->productRepository->find($request->attributes->get('id'));
        $product->setTitle($content->title)
            ->setDescription($content->description)
            ->setCategory($this->categoryRepository->find($content->category_id))
            ->setWeight($content->weight)
            ->setPrice($content->price)
            ->setIsBest($content->isBest)
            ->setIsAvailaible($content->isAvailaible);

        $this->manager->flush();

        return new JsonResponse('Le produit n°'.$product->getTitle().' a été modifié', 200);
    }

    #[Route('/product/delete/{id}', name: 'admin_delete_product', methods: 'DELETE')]
    public function deleteProduct(Request $request): Response
    {
        $product = $this->productRepository->find($request->attributes->get('id'));
        $this->manager->remove($product);
        $this->manager->flush();

        return new JsonResponse('Un produit a été supprimé', 200);
    }

}
