<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\ComposerRepository;
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
    public function index(RecetteRepository $repRecipe, ComposerRepository $repComp, Request $request): Response
    {
        /** @var Membre $user */
        $user = $this->getUser();
        $userId = $user ? $user->getId() : 0; //User par défault id 0

        $idRecipe = $request->get('id');

        $recipe = $repRecipe->findByRecipeId($userId, $idRecipe);
        $components = $repComp->findAllComponentsByRecipeId($idRecipe);

        //dump($recipe);

        $avatarFilename = null;
        if ($user) {
            $avatarFilename = $user->getAvatarFileName();
        }

        return $this->render('details/index.html.twig', [
            'recipe' => $recipe,
            'components' => $components,
            'membre_avatarFilename' => $avatarFilename,
        ]);
    }

    #[Route('/details/fav/update', name: 'app_details_fav_update')]
    public function updateFavByDetails(
        InteragirRepository $repo,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_BOOLEAN)] ?bool $fav,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $idRecipe,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $note
    ) {
        /** @var Membre $user */
        $user = $this->getUser();

        //Rajoute une nouvelle ligne dans la BD, si aucune interaction avant
        if($fav === null) {
            $repo->insertDB($user->getId(), $idRecipe, 1);
        } else {
            $repo->updateDB($fav, $user->getId(), $idRecipe, $note);
        }

        return $this->redirectToRoute('app_details', ['id' => $idRecipe ]);
    }

    #[Route('/details/{note}', name: 'app_details_note')]
    public function showNote($recipe): Response
    {
        return $this->render('details/_note.html.twig', ['recipe' => $recipe]);
    }

    #[Route('/details/note/update', name: 'app_details_note_update')]
    public function updateNote(
        InteragirRepository $repo,
        RecetteRepository $repoRecipe,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_BOOLEAN)] ?bool $fav,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $idRecipe,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $note
    ) {
        /** @var Membre $user */
        $user = $this->getUser();

        //Rajoute une nouvelle ligne dans la BD, si aucune interaction avant
        if($fav === null) {
            $repo->insertDB($user->getId(), $idRecipe, 0, $note);
        } else {
            $repo->updateDB(3, $user->getId(), $idRecipe, $note);
        }
        $repoRecipe->updateAverageNote($idRecipe);
        return $this->redirectToRoute('app_details', ['id' => $idRecipe ]);
    }
}

