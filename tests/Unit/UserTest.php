<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testCreateUser()
    {
        $user = new User();
        $user->setLastName('Hassan')
            ->setFirstName('Derkaoui')
            ->setEmail('email@test.fr')
            ->setRoles(['ROLEE_USER']);

        $this->assertEquals('Hassan', $user->getLastName());
        $this->assertEquals('Derkaoui', $user->getFirstName());
        $this->assertCount(2, $user->getRoles());
    }
}