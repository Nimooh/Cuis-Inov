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
        try {
            /** @var \App\Entity\Membre $user */
            $user = $this->getUser();
        } catch (\InvalidArgumentException) {
            $user = null;
        }

        $avatarFilename = null;
        if ($user) {
            $avatarFilename = $user->getAvatarFileName();
        }

        $userId = $user ? $user->getId() : 0; //User par défault id 0

        if (!isset($_POST['search'])) {
            $_POST['search'] = null;
        }
        if (!isset($_POST['difficulte'])) {
            $_POST['difficulte'] = null;
        }
        if (!isset($_POST['temps'])) {
            $_POST['temps'] = null;
        }
        if (!isset($_POST['note'])) {
            $_POST['note'] = null;
        }
        if (!isset($_POST['ingredient_oui'])) {
            $_POST['ingredient_oui'] = null;
        }
        if (!isset($_POST['ingredient_non'])) {
            $_POST['ingredient_non'] = null;
        }
        if (!isset($_POST['categorie'])) {
            $_POST['categorie'] = null;
        }
        if (!isset($_POST['allergene'])) {
            $_POST['allergene'] = null;
        }

        $trending = $repo->findMostTrending();
        if (!empty($trending)) {
            $trendingId = $trending->getId();
            $recettes = $repo->findAllOrderedWithoutMostTrending($trendingId, $userId, $_POST['search'], $_POST['difficulte'], $_POST['temps'], $_POST['note'], $_POST['ingredient_oui'], $_POST['ingredient_non'], $_POST['categorie'], $_POST['allergene']);
        } else {
            $recettes = $repo->findAllOrderedWithoutMostTrending(0, $userId, $_POST['search'], $_POST['difficulte'], $_POST['temps'], $_POST['note'], $_POST['ingredient_oui'], $_POST['ingredient_non'], $_POST['categorie'], $_POST['allergene']);
        }
        //dump($recettes);
        return $this->render('home/index.html.twig', ['recettes' => $recettes, 'trending' => $trending, 'membre_avatarFilename' => $avatarFilename]);
    }

    #[Route('/update', name: 'app_recette_update')]
    public function updateDB(InteragirRepository $repo, #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $fav,
                             #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $idRecette)
    {
        /** @var \App\Entity\Membre $user */
        $user = $this->getUser();

        //Redirection vers la page de connexion, si l'utilisateur non-connecté se retrouve sur cette page
        if($user === null)
            return $this->redirectToRoute('app_login', [], 303);
        //Rajoute une nouvelle ligne dans la BD, si aucune interaction avant
        if($fav === 3)
            $repo->insertDB($user->getId(), $idRecette, 1);
        else
            $repo->updateDB($fav, $user->getId(), $idRecette);

        return $this->redirectToRoute('app_home');
    }
}
