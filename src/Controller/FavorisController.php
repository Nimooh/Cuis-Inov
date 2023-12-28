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

        //Redirection vers la page de connexion, si l'utilisateur non-connecté se retrouve sur cette page
        if($user === null)
            return $this->redirectToRoute('app_login', [], 303);

        $favoris = $repo->findWithMembre($user->getId());
        return $this->render('favoris/index.html.twig', ['favoris' => $favoris]);
    }
}
