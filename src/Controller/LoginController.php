<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $membre = $this->getUser();
        $membreID = 0;
        if ($membre)
            $membreID = $membre->getId();
        $pathAvatarMembre = null;

        if (is_file('img/avatars/'.$membreID.'.png')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.png';
        } elseif (is_file('img/avatars/'.$membreID.'.jpg')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.jpg';
        } elseif (is_file('img/avatars/'.$membreID.'.jpeg')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.jpeg';
        }

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'pathAvatarMembre' => $pathAvatarMembre]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
