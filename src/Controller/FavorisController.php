<?php

namespace App\Controller;

use App\Repository\InteragirRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavorisController extends AbstractController
{
    #[Route('/favoris', name: 'app_favoris')]
    public function index(InteragirRepository $repo, Request $request): Response
    {
        $query = $request->query->get('search', '');
        $favoris = $repo->search($query);

        return $this->render('favoris/index.html.twig', ['favoris' => $favoris]);
    }
}
