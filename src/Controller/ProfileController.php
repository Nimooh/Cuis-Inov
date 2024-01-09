<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function show(): Response
    {
        $member = $this->getUser();

        return $this->render('profile/index.html.twig', ['member' => $member]);
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

