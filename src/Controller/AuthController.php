<?php

namespace App\Controller;

use App\Entity\User;
use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


class AuthController extends BaseController
{

    #[Route('login', name: 'login', methods: "GET", options: ['expose' => true])]
    public function loginView(?User $user)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Home/Index');
        }
        return $this->renderWithInertia('Login');
    }
    #[Route('/login', name: 'app_login', methods: "POST", options: ['expose' => true])]
    public function login(?User $user)
    {
        $user = $this->getUser();
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('home');
        }
        return $this->json(['user' => $user->getUserIdentifier()]);
    }

    #[Route('app_logout', name: 'app_logout', methods: "GET", options: ['expose' => true])]
    public function logout(): void
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
