<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        // on créé un utilisateur manuellement
        // penser à ajouter : EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher dans les parenthèses la fonction index()
        // $user = new User();
        // $user->setEmail('contact@popcorndigital.fr');
        // $user->setPassword($userPasswordHasher->hashPassword($user, 'password'));
        // $user->setFirstName('Jérôme');
        // $user->setLastName('Ollivier');
        // $entityManager->persist($user);
        // $entityManager->flush();

        return $this->render('home_page/index.html.twig');
    }
}
