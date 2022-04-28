<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


#Route("/api/")
class CustomerController extends BaseController
{
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('customer', name: 'customer', methods: ["GET"], options: ['expose' => true])]
    public function index(CustomerRepository $customer): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Customer/Index', [
                'customers' => $customer->findAll()
            ]);
        } else {
            return $this->redirect($this->generateUrl('login'));
        }
    }

    #[Route('customer/create', name: 'customer_create', methods: ["GET"], options: ['expose' => true])]
    public function create(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Customer/Create');
        } else {
            return $this->redirect($this->generateUrl('login'));
        }
    }

    #[Route('customer/store', name: 'customer_store', methods: ["POST"], options: ['expose' => true])]
    public function store(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $data = json_decode($request->getContent());
            $customer = new Customer();
            $customer->setName($data->name);
            $customer->setEmail($data->email);
            $customer->setAddress($data->address);
            $customer->setCity($data->city);
            $customer->setState($data->state);
            $customer->setCountry($data->country);
            $customer->setCreatedAt(new \DateTime());
            $em = $this->doctrine->getManager();
            $em->persist($customer);
            $em->flush();
            return $this->json(['success' => true]);
        } else {
            return $this->json(['success' => false], 401);
        }
    }

    #[Route('customer/edit/{id}', name: 'customer_edit', methods: ["GET"], options: ['expose' => true])]
    public function edit(CustomerRepository $customer, $id): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->renderWithInertia('Customer/Edit', [
                'customer' => $customer->find($id)
            ]);
        } else {
            return $this->redirect($this->generateUrl('login'));
        }
    }

    #[Route('customer/update/{id}', name: 'customer_update', methods: ["POST"], options: ['expose' => true])]
    public function update(CustomerRepository $customer, Request $request, $id)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $data = json_decode($request->getContent());
            $customer = $customer->find($id);
            if ($customer) {
                $customer->setName($data->name);
                $customer->setEmail($data->email);
                $customer->setAddress($data->address);
                $customer->setCity($data->city);
                $customer->setState($data->state);
                $customer->setCountry($data->country);
                $customer->setUpdatedAt(new \DateTime());
                $em = $this->doctrine->getManager();
                $em->persist($customer);
                $em->flush();
            } else {
                return $this->json(['success' => false], 404);
            }
            return $this->json(['success' => true]);
        } else {
            return $this->json(['success' => false], 401);
        }
    }
}
