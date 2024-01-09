<?php

namespace App\Controller;

use App\Repository\InteragirRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class FavorisController extends AbstractController
{
    #[Route('/favoris', name: 'app_favoris')]
    public function index(InteragirRepository $repo): Response
    {
        /** @var \App\Entity\Membre $user */
        $user = $this->getUser();

        $membreID = 0;
        if ($user) {
            $membreID = $user->getId();
        }
        $pathAvatarMembre = null;

        if (is_file('img/avatars/'.$membreID.'.png')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.png';
        } elseif (is_file('img/avatars/'.$membreID.'.jpg')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.jpg';
        } elseif (is_file('img/avatars/'.$membreID.'.jpeg')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.jpeg';
        }

        //Redirection vers la page de connexion, si l'utilisateur non-connecté se retrouve sur cette page
        if($user === null)
            return $this->redirectToRoute('app_login', [], 303);

        $favoris = $repo->findWithMembre($user->getId());
        return $this->render('favoris/index.html.twig', ['favoris' => $favoris, 'pathAvatarMembre' => $pathAvatarMembre]);
    }

    #[Route('/favoris/update', name: 'app_favoris_update')]
    public function updateDB(InteragirRepository $repo, #[MapQueryParameter(filter: \FILTER_VALIDATE_BOOLEAN)] bool $fav,
                             #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $idRecette)
    {
        /** @var \App\Entity\Membre $user */
        $user = $this->getUser();

        //Redirection vers la page de connexion, si l'utilisateur non-connecté se retrouve sur cette page
        if($user === null)
            return $this->redirectToRoute('app_login', [], 303);

        $repo->updateDB($fav, $user->getId(), $idRecette);

        //return new Response('', Response::HTTP_OK);
        return $this->redirectToRoute('app_favoris');
    }
}
