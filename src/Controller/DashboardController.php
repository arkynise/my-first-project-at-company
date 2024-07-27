<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Equipment;
use App\Entity\Employees;
use App\Entity\TypesEquipment;

class DashboardController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dashboard/employee', name: 'app_dashboard_employee')]
    public function employee(): Response
    {
        $Emp = $this->entityManager->getRepository(Employees::class)->findBy([], ['date_de_creetion' => 'DESC']);
        return $this->render('employee/employee.html.twig',[
            'Emps' => $Emp
        ]);
    }

    




    #[Route('/dashboard/equipment', name: 'app_dashboard_equipment')]
    public function equipment(): Response
    {
        
        $Eqp = $this->entityManager->getRepository(Equipment::class)->findBy([], ['date_ajoute' => 'DESC']);
       
        return $this->render('equipment/equipment.html.twig',
    [
        'Equipments' => $Eqp,
    ]);
    }
    

    #[Route('dashboard/TypeEquipment', name: 'app_dashboard_TypeEquipment')]
    public function TypeEquipment(): Response
    {
        
        $Eqp = $this->entityManager->getRepository(TypesEquipment::class)->findBy([], ['date_creetion' => 'DESC']);
       
        return $this->render('equipment/typeEquipment.html.twig',
    [
        'types' => [],
    ]);
    }

    #[Route('/equipment/ajoute', name: 'add_equipment')]
    public function AddEquipment(): Response
    {   
        return $this->render('equipment/addEquipment.html.twig');
    }


    #[Route('/equipment/ajouteTypeEquipment', name: 'add_equipment')]
    public function AddTypeEquipment(): Response
    {   
        return $this->render('equipment/ajouteTypeEqp.html.twig');
    }



}


