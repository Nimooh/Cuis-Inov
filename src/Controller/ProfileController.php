<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Repository\AllergeneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function show(AllergeneRepository $repository): Response
    {
        $membre = $this->getUser();
        $membreID = $membre->getId();
        $pathAvatarMembre = null;

        if (is_file('img/avatars/'.$membreID.'.png')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.png';
        } elseif (is_file('img/avatars/'.$membreID.'.jpg')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.jpg';
        } elseif (is_file('img/avatars/'.$membreID.'.jpeg')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.jpeg';
        }

        $allergenes = $repository->findWithMembre($membreID);

        return $this->render('profile/index.html.twig', [
            'membre' => $membre,
            'membre_id' => $membreID,
            'allergenes' => $allergenes,
            'pathAvatarMembre' => $pathAvatarMembre,
        ]);
    }

    #[Route('/profile/update', name: 'app_profile_update')]
    public function update(EntityManagerInterface $entityManager, Request $request): Response
    {
        $membre = $this->getUser();
        $membreID = $membre->getId();
        $pathAvatarMembre = null;

        if (is_file('img/avatars/'.$membreID.'.png')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.png';
        } elseif (is_file('img/avatars/'.$membreID.'.jpg')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.jpg';
        } elseif (is_file('img/avatars/'.$membreID.'.jpeg')) {
            $pathAvatarMembre = 'img/avatars/'.$membreID.'.jpeg';
        }

        $form = $this->createForm(ProfileType::class, $membre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            unlink($pathAvatarMembre);
            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {
                $newFilename = $membre->getId().'.'.$avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
            }

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/update.html.twig', [
            'membre' => $membre,
            'form' => $form,
            'pathAvatarMembre' => $pathAvatarMembre,
        ]);
    }

    #[Route('/profile/delete', name: 'app_profile_delete')]
    public function delete(EntityManagerInterface $entityManager, Request $request): Response
    {
        $membre = $this->getUser();

        $form = $this->createFormBuilder($membre)
            ->add('supprimer', SubmitType::class)
            ->add('annuler', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() && 'supprimer' === $form->getClickedButton()->getName()) {
                $entityManager->remove($membre);

                $entityManager->flush();

                return $this->redirectToRoute('app_home');
            } else {
                return $this->redirectToRoute('app_profile_update');
            }
        }

        return $this->render('profile/delete.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

}
