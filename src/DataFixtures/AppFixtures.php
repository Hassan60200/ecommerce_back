<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher, private readonly CategoryRepository $categoryRepository)
    {
        $this->faker = Factory::create('fr_FR');

    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setLastName($this->faker->lastName)
                ->setFirstName($this->faker->firstName)
                ->setPassword($this->passwordHasher->hashPassword($user, 'adminPassword'))
                ->setRoles(['ROLE_ADMIN'])
                ->setEmail($this->faker->email);
            $manager->persist($user);
        }

        $categoriesList = [
            'Électronique',
            'Livres',
            'Vêtements',
            'Maison & Jardin',
            'Jouets & Jeux',
            'Sport & Plein Air',
            'Beauté & Santé'
        ];
        $categories = [];
        foreach ($categoriesList as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setDescription($this->faker->sentence);
            $manager->persist($category);
            $categories[] = $category;
        }

        $products = [];
        for ($i = 0; $i < 50; $i++) {
            $product = $this->newProduct($categories);
            $manager->persist($product);
            $products[] = $product;
        }
        $manager->flush();
    }

    public function newProduct(array $categories): Product
    {
        return (new Product())
            ->setTitle($this->faker->words(3, true))
            ->setDescription($this->faker->text)
            ->setPrice($this->faker->randomFloat(2, 10, 200))
            ->setWeight($this->faker->randomFloat(1, 1, 200))
            ->setIsAvailaible($this->faker->boolean())
            ->setCategory($this->faker->randomElement($categories))
            ->setIsBest($this->faker->boolean());
    }
}
