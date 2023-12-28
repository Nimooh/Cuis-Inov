<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RecetteRepository $repo): Response
    {
        $trending = $repo->findMostTrending();

        $trendingId = $trending->getId();
        $recettes = $repo->findAllOrderedWithoutMostTrending($trendingId);

        return $this->render('home/index.html.twig', ['recettes' => $recettes, 'trending' => $trending]);
    }
}
