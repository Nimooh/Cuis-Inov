<?php

namespace App\Controller;

use App\Repository\InteragirRepository;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    #[Route('/details', name: 'app_details')]
    public function index(RecetteRepository $rep, Request $request): Response
    {
        /** @var \App\Entity\Membre $user */
        $user = $this->getUser();
        $userId = $user ? $user->getId() : 0; //User par défault id 0
        $idRecipe = $request->get('id');

        dump($idRecipe);

        $recipe = $rep->findByRecipeId($userId, $idRecipe);
        $components = $rep->findAllComponentsByRecipeId($idRecipe);

        return $this->render('details/index.html.twig', [
            'recipe' => $recipe,
            'components' => $components
        ]);
    }

    #[Route('/details/update', name: 'app_details_update')]
    public function updateDBByDetails(
        InteragirRepository $repo,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_BOOLEAN)] ?bool $fav,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $idRecette
    ) {
        /** @var \App\Entity\Membre $user */
        $user = $this->getUser();

        //Rajoute une nouvelle ligne dans la BD, si aucune interaction avant
        if($fav === null) {
            $repo->insertDB($user->getId(), $idRecette);
        } else {
            $repo->updateDB($fav, $user->getId(), $idRecette);
        }
        return $this->redirectToRoute('app_details', ['id' => $idRecette ]);
    }
}
