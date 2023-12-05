<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RecetteRepository $repo): Response
    {
        $trending = $repo->findMostTrending()[0];
        $recettes = $repo->findAllOrderedWithoutMostTrending();

        return $this->render('home/index.html.twig', ['recettes' => $recettes, 'trending' => $trending]);
    }


    #[Route("/image/{id}", name: 'app_show_image', requirements: ['id' => Requirement::DIGITS])]
    public function showImage(RecetteRepository $repo, int $id): Response
    {
        return new Response(
            $repo->findImgFromId($id)[0]["img_recette"],
            Response::HTTP_OK,
            ['content-type' => 'image/png']
        );
    }
}
