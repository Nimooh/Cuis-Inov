<?php

namespace App\Controller;

use App\Repository\AllergeneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function show(AllergeneRepository $repository): Response
    {
        $membre = $this->getUser();
        $membre_id = $membre->getId();

        $allergenes = $repository->findWithMembre($membre_id);

        return $this->render('profile/index.html.twig', [
            'membre' => $membre,
            'membre_id' => $membre_id,
            'allergenes' => $allergenes,
        ]);
    }

    #[Route('/profile/update', name: 'app_profile_update')]
    public function update(AllergeneRepository $repository): Response
    {
        $membre = $this->getUser();
        $membre_id = $membre->getId();

        $allergenes = $repository->findWithMembre($membre_id);

        return $this->render('profile/update.html.twig', [
            'membre' => $membre,
            'membre_id' => $membre_id,
            'allergenes' => $allergenes,
        ]);
    }

    #[Route('/profile/delete', name: 'app_profile_delete')]
    public function delete(): Response
    {
        $memberId = $this->getUser()->getId();

        return $this->render('profile/delete.html.twig', ['memberId' => $memberId]);
    }
}
