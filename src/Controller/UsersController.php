<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;



class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $users = $entityManager->getRepository(users::class)->findBy([], ['date_creetion' => 'DESC']);
        return $this->render('users/users.html.twig', [
            'users' => $users,
        ]);
    }




    #[Route('/users/addUser', name: 'app_users_add')]
    public function templateUser(Request $request,EntityManagerInterface $entityManager): Response
    {
        

        $query = $entityManager->createQuery(
            'SELECT e.email
            FROM App\Entity\Employees e ' 
        );

        $emails=$query->getResult();
        return $this->render('users/addUser.html.twig', [
            'emails'=>$emails
        ]);
    }



    #[Route('/user/save', name: 'app_users_save')]
    public function saveUser(Request $request,UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $user->setEmail($request->get('email'));
        $password=$request->get('password_field');
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        
        $user->setType($request->get('type'));
        $user->setDateCreetion(new \DateTime());
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('typeEquipent');
    }
}
