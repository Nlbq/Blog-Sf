<?php
namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController{


    /**
     * @Route("/", name="home")
     */
    public function home(ArticleRepository $articleRepository)
    {
        

        return  $this->render ( 'index.html.twig', [
            "articles" => $articleRepository->findBy(["published" => 1])
        ]);
    }
}