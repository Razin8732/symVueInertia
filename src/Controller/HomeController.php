<?php

namespace App\Controller;

use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    #[Route('/', name: 'home')]
    public function index()
    {
        // sleep(2);
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Home/Index');
        } else {
            return $this->renderWithInertia('Login');
        }
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Home/Dashboard');
        } else {
            return $this->renderWithInertia('Login');
        }
    }

    #[Route('/about', name: 'about')]
    public function about()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Home/About', [
                'user' => $this->getUser(),
            ]);
        } else {
            return $this->renderWithInertia('Login');
        }
    }
}
