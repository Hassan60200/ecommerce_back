<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private \Faker\Generator $faker;

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher, private readonly CategoryRepository $categoryRepository)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; ++$i) {
            $user = new User();
            $user->setLastName($this->faker->lastName)
                ->setFirstName($this->faker->firstName)
                ->setPassword($this->passwordHasher->hashPassword($user, 'adminPassword'))
                ->setRoles(['ROLE_ADMIN'])
                ->setCreatedAt(new \DateTimeImmutable('now'))
                ->setEmail($this->faker->email);
            $manager->persist($user);
        }

        $customers = [];
        for ($j = 0; $j < 5; ++$j) {
            $client = new User();
            $client->setLastName($this->faker->lastName)
                ->setFirstName($this->faker->firstName)
                ->setPassword($this->passwordHasher->hashPassword($client, 'userPassword'))
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt(new \DateTimeImmutable('now'))
                ->setEmail($this->faker->email);
            $manager->persist($client);
            $customers[] = $client;
        }

        $categoriesList = [
            'Électronique',
            'Livres',
            'Vêtements',
            'Maison & Jardin',
            'Jouets & Jeux',
            'Sport & Plein Air',
            'Beauté & Santé',
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
        for ($i = 0; $i < 50; ++$i) {
            $product = $this->newProduct($categories);
            $manager->persist($product);
            $products[] = $product;
        }

        $comments = [];
        for ($c = 0; $c < 15; ++$c) {
            $comment = $this->newComment($customers, $products);
            $manager->persist($comment);
            $comments[] = $comment;
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


    public function newComment(array $customers, array $products): Comment
    {
        return (new Comment())
            ->setUser($this->faker->randomElement($customers))
            ->setProduct($this->faker->randomElement($products))
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setMessage($this->faker->text)
            ->setRating(5);
    }
}
