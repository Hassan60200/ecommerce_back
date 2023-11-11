<?php

namespace App\Service;

use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthentificationManager
{
    private $userProvider;
    private $passwordEncoder;
    private $JWTManager;

    public function __construct(UserProviderInterface $userProvider, UserPasswordEncoderInterface $passwordEncoder, JWTTokenManagerInterface $JWTManager)
    {
        $this->userProvider = $userProvider;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTManager = $JWTManager;
    }
}