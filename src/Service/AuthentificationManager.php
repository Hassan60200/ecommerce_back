<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthentificationManager
{
    private $userProvider;
    private $passwordEncoder;
    private $JWTManager;

    public function __construct(UserProviderInterface $userProvider, UserPasswordHasherInterface $passwordEncoder, JWTTokenManagerInterface $JWTManager, private readonly UserPasswordHasherInterface $passwordHasher, private readonly EntityManagerInterface $manager)
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

    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    public function registration(array $data): JsonResponse
    {
        $user = new User();
        $user->setLastName($data['lastName'])
            ->setFirstName($data['firstName'])
            ->setPassword($this->passwordHasher->hashPassword($user, $data['password']))
            ->setRoles(['ROLE_CUSTOMER'])
            ->setEmail($data['email']);

        if ($this->emailExists($data['email'])) {
            throw new \Exception('L\'adresse e-mail est déjà utilisée.');
        }
        $this->manager->persist($user);
        $this->manager->flush();

        return new JsonResponse($user, 200);
    }

    private function emailExists(string $email): bool
    {
        $existingUser = $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);

        return null !== $existingUser;
    }
}
