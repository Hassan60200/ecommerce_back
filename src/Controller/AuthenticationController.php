<?php

namespace App\Controller;

use App\Service\AuthentificationManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationController extends AbstractController
{
    public function __construct(private readonly AuthentificationManager $authManager)
    {
    }

    #[Route('/login', name: 'app_authentication')]
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $token = $this->authManager->login($data['email'], $data['password']);
            return new JsonResponse(['token' => $token]);
        } catch (AuthenticationException $e) {
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
    }
    #[Route('/registration', name: 'app_registration', methods: ['POST'])]
    public function registration(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $user = $this->authManager->registration($data);
            return new JsonResponse(['message' => 'User registered successfully'], Response::HTTP_OK);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
