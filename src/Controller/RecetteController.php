<?php

namespace App\Controller;

use App\Entity\Membre;
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
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/mes_recettes', name: 'app_crud_mes_recettes')]
    public function index(RecetteRepository $rep, Request $request): Response
    {
        $user = $this->getUser();
        $myRecipes = $user->getRecettes();
        $avatarFilename = $user->getAvatarFileName();

        //dump($myRecipes);

        return $this->render('recette/mes_recettes.html.twig', [
            'recipes' => $myRecipes,
            'membre_avatarFilename' => $avatarFilename,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/recette/create', name: 'app_crud_recette_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        $avatarFilename = $user->getAvatarFileName();

        $recipe = new Recette();
        $form = $this->createForm(RecetteType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setNoteMoyenne(0);

            $user->addRecette($recipe);

            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('app_details').'?id='.$recipe->getId());
        }

        return $this->render('recette/create.html.twig', [
            'form' => $form,
            'membre_avatarFilename' => $avatarFilename,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/recette/{id}/update', name: 'app_crud_recette_update', requirements: ['id' => Requirement::DIGITS])]
    public function update(EntityManagerInterface $entityManager, Recette $recipe, Request $request): Response
    {
        $user = $this->getUser();
        $avatarFilename = $user->getAvatarFileName();

        $myRecipes = $user->getRecettes();

        if (!$myRecipes->contains($recipe)) {
            return new Response('Unauthorized', 403);
        }

        $form = $this->createForm(RecetteType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirect($this->generateUrl('app_details').'?id='.$recipe->getId());
        }

        return $this->render('recette/update.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
            'membre_avatarFilename' => $avatarFilename,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/recette/{id}/delete', name: 'app_crud_recette_delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete(EntityManagerInterface $entityManager, Recette $recipe, Request $request): Response
    {
        $user = $this->getUser();
        $avatarFilename = $user->getAvatarFileName();

        $myRecipes = $user->getRecettes();

        if (!$myRecipes->contains($recipe)) {
            return new Response('Unauthorized', 403);
        }

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
                return $this->redirect($this->generateUrl('app_details').'?id='.$recipe->getId());
            }
        }

        return $this->render('recette/delete.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
            'membre_avatarFilename' => $avatarFilename,
        ]);
    }
}
