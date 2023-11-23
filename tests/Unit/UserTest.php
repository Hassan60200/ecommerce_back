<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testCreateCustomer()
    {
        $user = new User();
        $user->setLastName('Hassan')
            ->setFirstName('Derkaoui')
            ->setEmail('emailCustomer@test.fr')
            ->setRoles(['ROLEE_CUSTOMER']);

        $this->assertEquals('Hassan', $user->getLastName());
        $this->assertEquals('Derkaoui', $user->getFirstName());
        $this->assertCount(2, $user->getRoles());
        $this->assertIsArray($user->getRoles());
    }

    public function testCreateAdmin()
    {
        $user = new User();
        $user->setLastName('Test')
            ->setFirstName('Admin')
            ->setEmail('emailadmin@test.fr')
            ->setRoles(['ROLEE_ADMIN']);

        $this->assertEquals('Test', $user->getLastName());
        $this->assertEquals('Admin', $user->getFirstName());
        $this->assertCount(2, $user->getRoles());
    }
}