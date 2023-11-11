<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setLastName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setPassword($this->passwordHasher->hashPassword($user, getenv('USER_PASSWORD_FIXTURES')))
                ->setRoles(['ROLE_ADMIN'])
                ->setEmail($faker->email);
            $manager->persist($user);
        }

        $manager->flush();

        $manager->flush();
    }
}
