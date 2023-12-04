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

#[Route('/admin')]
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

    #[Route('/category/', name: 'admin_index_category', methods: 'GET')]
    public function categoryIndex(): JsonResponse
    {
        $category = $this->categoryRepository->getAllCategories();

        return new JsonResponse($category, 200);
    }

    #[Route('/category/add', name: 'admin_add_category', methods: 'POST')]
    public function categoryNew(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent());
        $category = new Category();
        $category->setName($content->name)
            ->setDescription($content->description);

        $this->manager->persist($category);
        $this->manager->flush();

        return new JsonResponse('Une nouvelle catégorie a été ajouté', 200);
    }

    #[Route('/category/edit/{id}', name: 'admin_edit_category', methods: 'PUT')]
    public function categoryEdit(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent());
        $category = $this->categoryRepository->find($request->attributes->get('id'));
        $category->setName($content->name)
            ->setDescription($content->description);

        $this->manager->flush();

        return new JsonResponse('La catégorie n°'.$category->getId().' a été modifié', 200);
    }

    #[Route('/category/delete/{id}', name: 'admin_delete_category', methods: 'DELETE')]
    public function categoryDelete(Request $request): JsonResponse
    {
        $category = $this->categoryRepository->find($request->attributes->get('id'));
        $this->manager->remove($category);
        $this->manager->flush();

        return new JsonResponse('Vous venez de supprimer une catégorie', 200);
    }
}
