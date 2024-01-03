<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use App\Repository\CategorieRecetteRepository;
use App\Repository\AllergeneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiltresController extends AbstractController
{
    #[Route('/filtres', name: 'app_filtres')]
    public function index(IngredientRepository $ings,CategorieRecetteRepository $cats, AllergeneRepository $alls ): Response
    {
        $ingredients = $ings->getNames();
        $categories = $cats->getNames();
        $allergenes = $alls->getNames();

        return $this->render('navbar/search.html.twig', [
            'ingredients' => $ingredients,'categories' => $categories,'allergenes' => $allergenes,
        ]);
    }
}
