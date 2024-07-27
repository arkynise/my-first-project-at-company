<?php

namespace App\Controller;

use App\Entity\Employees;
use App\Entity\Equipment;
use App\Entity\TypesEquipment;
use App\Entity\Mantonance;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class EquipmentController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }





    #[Route('/equipment/ajoute/sauvegarder', name: 'save_equipment')]
    public function saveEquipment(Request $request,EntityManagerInterface $entityManager): Response
    {   
        $Eqp = new Equipment();
        $Eqp->setNom($request->get('mark'));
        $Eqp->setModel($request->get('model'));
        $Eqp->setDescription($request->get('description'));
        $Eqp->setType($request->get('type'));

        $Eqp->setDateAjoute(new \DateTime());
        $imageFile = $request->files->get('image');
        if ($imageFile) {
        $imageName=$imageFile->getClientOriginalName();
        $originalFilename = "/images/equipment/".$imageName;
        $targetDirectory = "../public/images/equipment/";
        try {
            $imageFile->move(
                $targetDirectory,
                $originalFilename
            );
            $Eqp->setImage($imageName);
        } catch (FileException $e) {
            // Handle file exception, e.g., log error, return error message
            
            $Eqp->setImage('default_image.jpg');
        }
       
        
        
        }else{
            $Eqp->setImage('default_image.jpg');
        }
        
        

        $entityManager->persist($Eqp);
        $entityManager->flush();
        
        
        return $this->redirectToRoute('equipment');
    }
    




    #[Route('/equipment/search', name: 'search_equipment')]
    public function search(Request $request,EntityManagerInterface $entityManager): Response
    {
        $query = $entityManager->createQuery(
            'SELECT e FROM App\Entity\Equipment e
             WHERE e.nom LIKE :searchInput OR
              e.model LIKE :searchInput OR
                e.type=:typefield'
        );
        $searchInput = $request->get('search_field');
        $query->setParameter('searchInput', $searchInput.'%');
        $query->setParameter('typefield', $searchInput);
        $Eqp = $query->getResult();
        $length = count($Eqp);
        return $this->render('equipment/equipment.html.twig', [
            'Equipments'=>$Eqp ,
            'count'=>$length
        ]);

    }

    




    #[Route('/equipment/delete/{id}', name: 'delete_equipment')]
    public function deleteEntity(int $id,EntityManagerInterface $entityManager): Response
    {
        
        $entity = $entityManager->getRepository(Equipment::class)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Entity not found');
        }

        $entityManager->remove($entity);
        $entityManager->flush();

        // Optional: Add a flash message for user feedback
        $this->addFlash('success', 'Entity deleted successfully');

        return $this->redirectToRoute('equipment'); // Redirect to a route after deletion
    }



    

    

    #[Route('/equipment/saveupdate/{id}', name: 'save_update_equipment')]
    public function saveUpdateEquipment(Request $request,int $id,EntityManagerInterface $entityManager): Response
    {   


        
        $Eqp = $entityManager->getRepository(Equipment::class)->find($id);
        $Eqp->setNom($request->get('mark'));
        $Eqp->setModel($request->get('model'));
        $Eqp->setDescription($request->get('description'));
        $Eqp->setType($request->get('type'));
        $Eqp->setState($request->get('state'));
        $imageFile = $request->files->get('image');
        
        if ($imageFile) {
            $imageName=$imageFile->getClientOriginalName();
            $originalFilename = "/images/equipment/".$imageName;
            $targetDirectory = "../public/images/equipment/";
            try {
                $imageFile->move(
                    $targetDirectory,
                    $originalFilename
                );
                $Eqp->setImage($imageName);
            } catch (FileException $e) {
                
                
            }
            
            
            
            }else{
                $Eqp->setImage($request->get('original_image'));
            }
        
        $entityManager->flush();
        if($request->get('state')=='mantonance'){
            $details=$request->get('mnt_desc');
            $this->saveMantonance($Eqp,$details,$entityManager);
        }
        
        return $this->redirectToRoute('equipment');
    }

    

    




    #[Route('/equipment/sauvgardeTypeEquipment', name: 'update_equipment')]
    public function sauvgardeTypeEquipment(Request $request,EntityManagerInterface $entityManager): Response
    {   
        $type = new TypesEquipment();
        $type->setNomType($request->get('type_nom'));
        $type->setDateCreetion(new \DateTime());
        $entityManager->persist($type);
        $entityManager->flush();
        return $this->redirectToRoute('typeEquipent');

    }






    #[Route('/equipment/update/{id}', name: 'update_equipment')]
    public function updateEquipment(int $id,EntityManagerInterface $entityManager): Response
    {   
        $equipmentRepository=$this->entityManager->getRepository(Equipment::class);
        $Emp=$this->entityManager->getRepository(Employees::class)->findAll();
        $equipment = $equipmentRepository->find($id);

        
        return $this->render('equipment/updateEquipment.html.twig',[
            'eqp'=>$equipment,
            'Emps'=>$Emp
        ]);
    }



    



  
    private function saveMantonance(Equipment $eqp,string $desc, EntityManagerInterface $entityManager): void
    {
       

        $Mnt = new Mantonance();
        $Mnt->addNumeroEqp($eqp);
        $Mnt->setDateEntre(new \DateTime());
        $Mnt->setDetail($desc);
        $entityManager->persist($Mnt);
        $entityManager->flush();

    }


    
}
