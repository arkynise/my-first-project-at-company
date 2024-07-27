<?php

namespace App\Controller;


use App\Entity\Employees;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping\Id;

class LoginController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;


    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;

    }

    #[Route('/', name: 'app_login')]
    public function index(): Response
    {
        return $this->render("login/index.html.twig");
    }




    #[Route('/dashboard', name: 'app_valide_login',methods:"POST")]
    public function checklogin(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher , SessionInterface $session): Response
    {   $user = new Users();
        $username = $request->request->get('email');
        $password = $request->request->get('password');
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $query = $entityManager->createQuery(
            'SELECT u FROM App\Entity\Users u
             WHERE u.email = :username '
        );
        $query->setParameter('username', $username);
       
        $user = $query->getOneOrNullResult();
        if ($user === null) {
            $this->addFlash('error', $hashedPassword);
            return $this->redirect($request->headers->get('referer'));
            
        } 
        if ($this->passwordHasher->isPasswordValid($user, $password)) {

            $Emp = $this->entityManager->getRepository(Employees::class)->findBy([], ['date_de_creetion' => 'DESC']);
            return $this->render('employee/employee.html.twig', [
                'Emps'=>$Emp 
            ]);
        }
        else {
            $this->addFlash('error', $hashedPassword);
            return $this->redirect($request->headers->get('referer'));
            
            
        }
        
    }

}
