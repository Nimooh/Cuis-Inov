<?php

namespace App\Controller;

use App\Repository\AllergeneRepository;
use App\Repository\CategorieRecetteRepository;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiltresController extends AbstractController
{
    public function filtre(IngredientRepository $ings, CategorieRecetteRepository $cats, AllergeneRepository $alls): Response
    {
        $ingredients = $ings->findAll();
        $categories = $cats->findAll();
        $allergenes = $alls->findAll();

        return $this->render('navbar/search.html.twig', [
            'ingredients' => $ingredients, 'categories' => $categories, 'allergenes' => $allergenes,
        ]);
    }
}
