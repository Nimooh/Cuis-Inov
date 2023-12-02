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
        #$trending = $repo->findOneBy([stars_recette]);
        #$recettes = $repo->findAll([],['stars_recette' => 'ASC', 'nom_recette' => 'ASC']);
        $recettes = $repo->find(1);
        $img = $recettes->getImgRecette();

        #$imgEncoded = "data:image/png;base64," . base64_encode($img);
        #var_dump($img);
        return $this->render('home/index.html.twig', ['recettes' => $recettes, 'imgEncoded' => $img]);
    }
}
