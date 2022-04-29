<?php

namespace App\Controller;

use App\Controller\Traits\PaginationTrait;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

#Route("/api/")
class CustomerController extends BaseController
{
    use PaginationTrait;
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('customer', name: 'customer', methods: ["GET"], options: ['expose' => true])]
    public function index(Request $request, PaginatorInterface $paginator, CustomerRepository $customer): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {

            $search = $request->query->get('search');

            [$limit, $offset] = $this->getPaginationLimitAndOffset($request->query->getInt('page', 1));

            [$customers, $total] =  $customer->findAllMatchingFilter($search, $limit, $offset);

            $page = $request->query->get('page', 1);
            $pagination = $this->wrapWithPaginationData(
                $customers,
                $total,
                $page,
                'customer'
            );


            return $this->renderWithInertia('Customer/Index', [
                'customers' => $pagination,
                'search' => $search,
                'currentpage' => (int) $page
            ]);
        } else {
            return $this->redirect($this->generateUrl('login'));
        }
    }

    #[Route('customer/search', name: 'customer_search', methods: ["GET"], options: ['expose' => true])]
    public function customer_search(Request $request, CustomerRepository $customer)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {

            $search = $request->query->get('search');
            $perpage = $request->query->get('perPage');

            [$limit, $offset] = $this->getPaginationLimitAndOffset($request->query->getInt('page', 1), $perpage);

            [$customers, $total] =  $customer->findAllMatchingFilter($search, $limit, $offset);

            $page = $request->query->get('page', 1);
            $pagination = $this->wrapWithPaginationData(
                $customers,
                $total,
                $page,
                'customer',
                $perpage
            );

            return $this->json([
                'success' => true,
                'customers' => $pagination,
                'currentpage' => (int) $page
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
