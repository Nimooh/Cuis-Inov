<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RecetteController extends AbstractController
{
    #[Route('/details', name: 'app_details')]
    public function index(RecetteRepository $rep, Request $request): Response
    {
        $id = $request->get('id');
        $recipe = $rep->find($id);
        $components = $rep->findAllComponentsByRecipeId($id);

        return $this->render('details/index.html.twig', [
            'recipe' => $recipe,
            'components' => $components,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/recette/create', name: 'app_recette_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $recipe = new Recette();
        $form = $this->createForm(RecetteType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirect('app_details?id='.$recipe->getId());
        }

        return $this->render('recette/create.html.twig', [
            'form' => $form,
        ]);

    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/recette/{id}/update', name: 'app_recette_update', requirements: ['id' => Requirement::DIGITS])]
    public function update(EntityManagerInterface $entityManager, Recette $recipe, Request $request): Response
    {
        $form = $this->createForm(RecetteType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirect('app_details?id='.$recipe->getId());
        }

        return $this->render('recette/update.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);

    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/recette/{id}/delete', name: 'app_recette_delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete(EntityManagerInterface $entityManager, Recette $recipe, Request $request): Response
    {
        $form = $this->createFormBuilder($recipe)
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ('delete' === $form->getClickedButton()?->getName()) {
                $entityManager->remove($recipe);

                $entityManager->flush();

                return $this->redirectToRoute('app_home');
            } else {
                return $this->redirect('app_details?id='.$recipe->getId());
            }
        }

        return $this->render('recette/delete.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }
}
