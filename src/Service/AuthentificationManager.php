<?php

namespace App\Service;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthentificationManager
{
    private $userProvider;
    private $passwordEncoder;
    private $JWTManager;

    public function __construct(UserProviderInterface $userProvider, UserPasswordHasherInterface $passwordEncoder, JWTTokenManagerInterface $JWTManager)
    {
        $this->userProvider = $userProvider;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTManager = $JWTManager;
    }

    public function login($username, $password): string
    {
        $user = $this->userProvider->loadUserByIdentifier($username);

        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return $this->JWTManager->create($user);
    }

}