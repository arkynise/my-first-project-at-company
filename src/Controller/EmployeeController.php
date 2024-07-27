<?php

namespace App\Controller;



use App\Entity\Employees;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DateTime\DateTime;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeController extends AbstractController
{
    #[Route('/employee/ajoute', name: 'ajoute_employee')]
    public function index(): Response
    {
        return $this->render('employee/addemployee.html.twig');
    }



    #[Route('/employee/update/{id}', name: 'ajoute_employee')]
    public function display_update(int $id,EntityManagerInterface $entityManager): Response
    {
        $entity = $entityManager->getRepository(Employees::class)->find($id);
        return $this->render('employee/updateemployee.html.twig',[
            'emp'=>$entity
        ]);
    }




    #[Route('/employee/update/save/{id}', name: 'ajoute_employee')]
    public function save_update(Request $request,int $id,EntityManagerInterface $entityManager): Response
    {
        $Emp = $entityManager->getRepository(Employees::class)->find($id);
        $Emp->setName($request->get('nom'));
        $Emp->setLastname($request->get('prenom'));
        if(!$request->get('ddn')){
            $Emp->setBirthday( \DateTime::createFromFormat('Y-m-d','0000-00-00'));
        }else{
            $Emp->setBirthday( \DateTime::createFromFormat('Y-m-d',$request->get('ddn')));
        }
        
        $Emp->setTelephone($request->get('telephone'));
       
        $Emp->setDateDeCreetion(new \DateTime());
        $Emp->setSalaire(floatval($request->get('salaire')));
        $Emp->setEmail($request->get('email'));

        $entityManager->flush();
        return $this->redirectToRoute('employee');
    }


    #[Route('/employee/sauvegarder', name: 'save_employee')]
    public function save(Request $request,EntityManagerInterface $entityManager): Response
    {

        $Emp = new employees();
        $Emp->setName($request->get('nom'));
        $Emp->setLastname($request->get('prenom'));
        if(!$request->get('ddn')){
            $Emp->setBirthday( \DateTime::createFromFormat('Y-m-d','0000-00-00'));
        }else{
            $Emp->setBirthday( \DateTime::createFromFormat('Y-m-d',$request->get('ddn')));
        }
        
        $Emp->setTelephone($request->get('telephone'));
       
        $Emp->setDateDeCreetion(new \DateTime());
        $Emp->setSalaire(floatval($request->get('salaire')));
        $Emp->setEmail($request->get('email'));

        $entityManager->persist($Emp);
        $entityManager->flush();
        return $this->redirectToRoute('employee');
    }
    



    #[Route('/employee/search', name: 'search_employee')]
    public function search(Request $request,EntityManagerInterface $entityManager): Response
    {
        $query = $entityManager->createQuery(
            'SELECT u FROM App\Entity\Employees u
             WHERE u.name LIKE :searchInput OR
              u.lastname LIKE :searchInput OR
              u.telephone LIKE :searchInput '
        );
        $searchInput = $request->get('search_field');
        $query->setParameter('searchInput', $searchInput.'%');
        $emp = $query->getResult();
        $length = count($emp);
        return $this->render('employee/employee.html.twig', [
            'Emps'=>$emp,
            'count'=>$length
        ]);

    }


    #[Route('/employee/delete/{id}', name: 'delete_employee')]
    public function deleteEntity(int $id,EntityManagerInterface $entityManager): Response
    {
        
        $entity = $entityManager->getRepository(Employees::class)->find($id);
    
        if (!$entity) {
            throw $this->createNotFoundException('Entity not found');
        }
    
        $entityManager->remove($entity);
        $entityManager->flush();
    
        // Optional: Add a flash message for user feedback
        $this->addFlash('success', 'Entity deleted successfully');
    
        return $this->redirectToRoute('employee'); // Redirect to a route after deletion
    }


}

