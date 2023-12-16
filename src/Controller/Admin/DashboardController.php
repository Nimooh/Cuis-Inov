<?php

namespace App\Controller\Admin;

use App\Entity\Allergene;
use App\Entity\CategorieRecette;
use App\Entity\Ingredient;
use App\Entity\Membre;
use App\Entity\Recette;
use App\Entity\Unite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle("Cuis'inov");
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Membre', 'fas fa-user', Membre::class);
        yield MenuItem::linkToCrud('Unité', 'fas fa-eye-dropper', Unite::class);
        yield MenuItem::linkToCrud('Ingrédient', 'fas fa-egg', Ingredient::class);
        yield MenuItem::linkToCrud('Allergène', 'fas fa-wheat-awn-circle-exclamation', Allergene::class);
        yield MenuItem::linkToCrud('Recette', 'fas fa-book', Recette::class);
        yield MenuItem::linkToCrud('Catégorie de recette', 'fas fa-layer-group', CategorieRecette::class);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
