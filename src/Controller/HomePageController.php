<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\NewsRepository;
use App\Service\NavCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    private $navCategory;
        public function __construct(NavCategory $navCategory)
        {
            $this->navCategory = $navCategory;
        }

    #[Route('/', name: 'app_home_page')]
    public function index(NewsRepository $newsRepository): Response
    {
        
        // on créé un utilisateur manuellement (on actualise la page d'accueil pour que ça créé l'utilisateur)
        // penser à ajouter : EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher dans les parenthèses la fonction index()
        // $user = new User();
        // $user->setEmail('contact@popcorndigital.fr');
        // $user->setPassword($userPasswordHasher->hashPassword($user, 'password'));
        // $user->setFirstName('Jérôme');
        // $user->setLastName('Ollivier');
        // $entityManager->persist($user);
        // $entityManager->flush();

        return $this->render('home_page/index.html.twig', [
            'news' => $newsRepository->findAll(),
            'categoryList' =>$this->navCategory->category()
        ]);
    }

    #[Route('/news/{id<[0-9]+>}', name: 'app_new_show')]
    public function newsShow($id, NewsRepository $newsRepository): Response
    {
        $newsId = $newsRepository->find($id);
        return $this->render('home_page/news_single.html.twig', [
            'single_news'=>$newsRepository->find($newsId),
            'categoryList' =>$this->navCategory->category()
        ]);
    }

    #[Route('/news/{id<[0-9]+>}/category', name: 'app_new_by_category_show')]
    public function NewsByCategory($id, NewsRepository $newsRepository, CategoryRepository $categoryRepository): Response
    {
        $idCategory = $categoryRepository->find($id);

        $categoryName = $categoryRepository->findOneBy(['id' => $id], []);
      
        $newsByCategory = $newsRepository->findBy(['category'=>$idCategory], []);

        return $this->render('home_page/newsByCategory.html.twig', [
            'news' => $newsByCategory,
            'categoryList' =>$this->navCategory->category(),
            'category'=>$categoryName
        ]);
    }
}
