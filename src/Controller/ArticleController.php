<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController{

    /**
     * @Route("/{id}/show", name="article_show")
     */

    public function show(Article $article): Response{

        return $this->render('article/show.html.twig', [
            "article" => $article
        ]);
    }


    /**
     * @Route("/article/new", name="article_new")
     */

    public function new(Request $request, ManagerRegistry $doctrine ): Response{

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }


        return  $this->render('article/new.html.twig', [
            "form" => $form->createView()
        ]);
}

    /**
     * @Route("/article/{id}/edit", name="article_edit")
     */
    public function edit(Article $article, Request $request, ManagerRegistry $doctrine):Response{

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('article/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}/delete", name="article_delete")
     */
    public function delete(Article $article, ManagerRegistry $doctrine): RedirectResponse{
        $entityManager = $doctrine->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}