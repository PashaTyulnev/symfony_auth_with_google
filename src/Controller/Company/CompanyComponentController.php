<?php

namespace App\Controller\Company;

use App\Entity\Address;
use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/components/company')]
class CompanyComponentController extends AbstractController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        readonly CompanyRepository $companyRepository,
        readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route(path: '/list', name: 'all_company_list_component', methods: ['GET'])]
    public function getCompanyListComponent(): Response
    {
        $companies = $this->companyRepository->findAll();

        $companies = $this->serializer->serialize(
            $companies,
            'jsonld',
            ['groups' => ['company:read']]
        );

        $companies = json_decode($companies, true);

        return $this->render('company/company_list.html.twig', [
            'companies' => $companies
        ]);
    }

    #[Route('/new', name: 'new_company_component', methods: ['GET', 'POST'])]
    public function getNewCompanyModalComponent(Request $request): Response
    {
        $company = new Company();
        $company->setAddress(new Address());
        $form = $this->createForm(CompanyType::class, $company);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($company);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_company');
        }

        return $this->render('company/company_modal.html.twig', [
            'form' => $form->createView(),
            'company' => null
        ]);
    }

    #[Route(path: '/edit/{companyId}', name: 'edit_company_component', methods: ['GET', 'POST'])]
    public function getEditCompanyModalComponent(int $companyId, Request $request): Response
    {
        $company = $this->companyRepository->find($companyId);

        if (!$company) {
            throw $this->createNotFoundException('Firma nicht gefunden');
        }

        // Address initialisieren, falls nicht vorhanden
        if (!$company->getAddress()) {
            $company->setAddress(new Address());
        }

        $form = $this->createForm(CompanyType::class, $company);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_company');
        }

        return $this->render('company/company_modal.html.twig', [
            'form' => $form->createView(),
            'company' => $company
        ]);
    }
}
