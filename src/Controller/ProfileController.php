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
        $member = $this->getUser();
        $member_id = $member->getId();

        $allergenes = $repository->findWithMembre($member_id);

        return $this->render('profile/index.html.twig', [
            'member' => $member,
            'member_id' => $member_id,
            'allergenes' => $allergenes,
        ]);
    }

    #[Route('/profile/update', name: 'app_profile_update')]
    public function update(): Response
    {
        $member = $this->getUser();

        return $this->render('profile/update.html.twig', ['member' => $member]);
    }

    #[Route('/profile/delete', name: 'app_profile_delete')]
    public function delete(): Response
    {
        $memberId = $this->getUser()->getId();

        return $this->render('profile/delete.html.twig', ['memberId' => $memberId]);
    }
}