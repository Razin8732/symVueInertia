<?php

namespace App\Controller;

use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(InertiaInterface $inertia)
    {
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $inertia->render('Home/Index', [
                'user' => $this->getUser(),
            ]);
        } else {
            return $inertia->render('Login');
        }
    }

    #[Route('/about', name: 'about')]
    public function about(InertiaInterface $inertia)
    {
        // return $inertia->render('Home/About', ['prop' => 'value']);
        // return $this->render('home/index.html.twig', [
        //     'controller_name' => 'HomeController',
        // ]);
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $inertia->render('Home/About', [
                'user' => $this->getUser(),
            ]);
        } else {
            return $inertia->render('Login');
        }
    }
}
