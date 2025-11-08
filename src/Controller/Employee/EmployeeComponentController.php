<?php

namespace App\Controller\Employee;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\DepartmentRepository;
use App\Repository\EmployeeRepository;
use App\StateProcessor\EmployeeStateProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/components/employee')]
class EmployeeComponentController extends AbstractController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        readonly DepartmentRepository $departmentRepository,
        readonly EmployeeRepository $employeeRepository,
        readonly EntityManagerInterface $entityManager,
        readonly EmployeeStateProcessor $employeeStateProcessor
    ) {
    }

    #[Route(path: '/list', name: 'all_employee_list_component', methods: ['GET'])]
    public function getEmployeeListComponent(): Response
    {
        $allEmployees = $this->employeeRepository->findAll();

        $allEmployees = $this->serializer->serialize(
            $allEmployees,
            'jsonld',
            ['groups' => ['employee:read']]
        );

        $allEmployees = json_decode($allEmployees, true);

        return $this->render('employee/employee_list.html.twig', [
            'employees' => $allEmployees
        ]);
    }

    #[Route(path: '/new', name: 'new_employee_component', methods: ['GET', 'POST'])]
    public function getNewEmployeeModalComponent(Request $request): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Daten aus dem Formular holen
            $username = $form->get('username')->getData();
            $email = $form->get('email')->getData();

            // User erstellen
            if ($username && $email) {
                $user = new \App\Entity\User();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setActive(true);
                $user->setRoles(['ROLE_EMPLOYEE']);
                $user->setEmployee($employee);
                $this->entityManager->persist($user);
            }

            $this->entityManager->persist($employee);
            $this->entityManager->flush();

            // Bei erfolgreichem Speichern: Redirect (Turbo Frame wird automatisch aktualisiert)
            return $this->redirectToRoute('app_employees');
        }

        // Bei GET oder bei Fehlern: Formular anzeigen
        return $this->render('employee/employee_modal.html.twig', [
            'form' => $form->createView(),
            'employee' => null
        ]);
    }

    #[Route(path: '/edit/{employeeId}', name: 'edit_employee_component', methods: ['GET', 'POST'])]
    public function getEditEmployeeModalComponent(int $employeeId, Request $request): Response
    {
        $employee = $this->employeeRepository->find($employeeId);

        if (!$employee) {
            throw $this->createNotFoundException('Mitarbeiter nicht gefunden');
        }

        $form = $this->createForm(EmployeeType::class, $employee);

        // User-Daten ins Formular einfügen
        if ($employee->getUser()) {
            $form->get('username')->setData($employee->getUser()->getUsername());
            $form->get('email')->setData($employee->getUser()->getEmail());
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // User aktualisieren
            $user = $employee->getUser();
            if ($user) {
                $username = $form->get('username')->getData();
                $email = $form->get('email')->getData();
                
                if ($username) {
                    $user->setUsername($username);
                }
                if ($email) {
                    $user->setEmail($email);
                }
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('app_employees');
        }

        return $this->render('employee/employee_modal.html.twig', [
            'form' => $form->createView(),
            'employee' => $employee
        ]);
    }
}
