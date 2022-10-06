<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/news')]
class NewsController extends AbstractController
{
    
    #[Route('/', name: 'app_news_index', methods: ['GET'])]
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('news/index.html.twig', [
            'news' => $newsRepository->findAll(),
            'categoryList' => $this->navCategory->category()
        ]);
    }

    #[Route('/new', name: 'app_news_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NewsRepository $newsRepository): Response
    {
        // on vérifie que l'utilisateur est connecté
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }

        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        //on va seter la date de création en la mettant à la date du jour
        $news->setCreatedAt(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {

            //ajoute l'utilisateur connecté en tant qu'auteur
            $news->setAuthor($this->getUser());
            $newsRepository->save($news, true);

            $this->addFlash('success', 'Votre nouvel article a bien été créé !');

            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('news/new.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_news_show', methods: ['GET'])]
    public function show(News $news): Response
    {
        return $this->render('news/show.html.twig', [
            'news' => $news,
            'categoryList' => $this->navCategory->category()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_news_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, News $news, NewsRepository $newsRepository): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
         //on va seter la date de mise à jour
        $news->setUpdatedAt(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {
            $newsRepository->save($news, true);

            $this->addFlash('success', 'Votre article a bien été modifié !');

            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('news/edit.html.twig', [
            'news' => $news,
            'form' => $form,
            'categoryList' => $this->navCategory->category()
        ]);
    }

    #[Route('/{id}', name: 'app_news_delete', methods: ['POST'])]
    public function delete(Request $request, News $news, NewsRepository $newsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $newsRepository->remove($news, true);

            $this->addFlash('info', 'Votre article a bien été supprimé !');
        }

        return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
    }
}


