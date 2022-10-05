<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(NewsRepository $newsRepository): Response
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

        return $this->render('home_page/index.html.twig', [
            'news' => $newsRepository->findAll()
        ]);
    }

    #[Route('/news/{id<[0-9]+>}', name: 'app_new_show')]
    public function newsShow($id, NewsRepository $newsRepository): Response
    {
        $newsId = $newsRepository->find($id);
        return $this->render('home_page/news_single.html.twig', [
            'single_news'=>$newsRepository->find($newsId)
        ]);
    }
}
