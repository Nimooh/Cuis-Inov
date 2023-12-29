<?php

namespace App\Controller;

use App\Repository\InteragirRepository;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
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

    #[Route('/update', name: 'app_recette_update')]
    public function updateDB(InteragirRepository $repo, #[MapQueryParameter(filter: \FILTER_VALIDATE_BOOLEAN)] bool $fav,
                             #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $idRecette)
    {
        /** @var \App\Entity\Membre $user */
        $user = $this->getUser();

        //Redirection vers la page de connexion, si l'utilisateur non-connecté se retrouve sur cette page
        if($user === null)
            return $this->redirectToRoute('app_login', [], 303);

        $repo->updateDB($fav, $user->getId(), $idRecette);

        return $this->redirectToRoute('app_home');
    }
}
