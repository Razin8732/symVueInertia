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


#[Route("/api")]
class AuthController extends AbstractController
{

    #[Route('/login', name: 'login', methods: "GET")]
    public function loginView(?User $user, InertiaInterface $inertia)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $inertia->render('Home/Index');
        }
        return $inertia->render('Login');
    }
    #[Route('/login', name: 'app_login', methods: "POST", options: ['expose' => true])]
    public function login(?User $user, InertiaInterface $inertia)
    {
        $user = $this->getUser();
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('home');

            // return $inertia->render('Home/Index', [
            //     'user' => $user
            // ]);
        }
        return $this->json(['user' => $user->getUserIdentifier()]);
    }

    #[Route('/logout', name: 'app_logout', methods: "GET")]
    public function logout(): void
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
