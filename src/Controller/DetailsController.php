<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    #[Route('/details', name: 'app_details')]
    public function index(RecetteRepository $rep, Request $request): Response
    {
        $id = $request->get('RecetteId');
        $recipe = $rep->find($id);
        //$components = $rep->findAllComponentById($id);
        return $this->render('details/index.html.twig', [
            'recipe' => $recipe,
            //'components' => $components
        ]);
    }
}
