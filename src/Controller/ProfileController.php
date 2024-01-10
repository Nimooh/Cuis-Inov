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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/profile', name: 'app_profile')]
    public function show(AllergeneRepository $repository): Response
    {
        $membre = $this->getUser();
        $membreID = $membre->getId();
        $allergenes = $repository->findWithMembre($membreID);

        return $this->render('profile/index.html.twig', [
            'membre' => $membre,
            'membre_id' => $membreID,
            'allergenes' => $allergenes,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/profile/update', name: 'app_profile_update')]
    public function update(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): Response
    {
        $membre = $this->getUser();

        $form = $this->createForm(ProfileType::class, $membre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {
                if ($membre->getAvatarFilename()) {
                    unlink($this->getParameter('images_dir').'/avatars/'.$membre->getAvatarFilename());
                }
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('images_dir').'/avatars',
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $membre->setAvatarFilename($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/update.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED')]
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
                if ($membre->getAvatarFilename()) {
                    unlink($this->getParameter('images_dir').'/avatars/'.$membre->getAvatarFilename());
                }
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

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/profile/resetAvatar', name: 'app_profile_resetavatar')]
    public function resetAvatar(EntityManagerInterface $entityManager): Response
    {
        $membre = $this->getUser();
        if ($membre->getAvatarFilename()) {
            unlink($this->getParameter('images_dir').'/avatars/'.$membre->getAvatarFilename());
        }

        $membre->setAvatarFilename(null);
        $entityManager->flush();

        return $this->redirectToRoute('app_profile_update');
    }

}
