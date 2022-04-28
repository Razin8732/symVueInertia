<?php

namespace App\Controller;

use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends BaseController
{
    public function __construct(Security $security)
    {
        if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // return $this->renderWithInertia('Home/Index');
            # TODO : redirect to login
        }
    }

    #[Route('/', name: 'home', options: ['expose' => true])]
    public function index()
    {
        // sleep(2);
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Home/Index');
        } else {
            return $this->redirect($this->generateUrl('login'));
        }
    }

    #[Route('/dashboard', name: 'dashboard', options: ['expose' => true])]
    public function dashboard()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Home/Dashboard');
        } else {
            return $this->redirect($this->generateUrl('login'));
        }
    }

    #[Route('/about', name: 'about', options: ['expose' => true])]
    public function about()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Home/About', [
                'user' => $this->getUser(),
            ]);
        } else {
            return $this->redirect($this->generateUrl('login'));
            // return $this->renderWithInertia('Login');
        }
    }
}
