<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiltresController extends AbstractController
{
    #[Route('/filtres', name: 'app_filtres')]
    public function index(): Response
    {
        return $this->render('filtres/index.html.twig', [
            'controller_name' => 'FiltresController',
        ]);
    }
}
