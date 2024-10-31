<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
//        $adminUser = new User();
//        $adminUser->setEmail('admin@test.com');
//        $adminUser->setName('admin');
//        $adminUser->setRoles(['ROLE_SUPER_ADMIN']);
//        $adminUser->setPassword($passwordHasher->hashPassword($adminUser, 'password'));
//        $em->persist($adminUser);
//        $em->flush();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
