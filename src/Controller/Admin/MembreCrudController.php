<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\IsAdminFilter;
use App\Entity\Membre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MembreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomMembre', 'Nom'),
            TextField::new('prnmMembre', 'Prénom'),
            EmailField::new('email', 'Adresse e-mail'),
            TelephoneField::new('telMembre', 'Numéro de téléphone'),
            ArrayField::new('roles')
                ->formatValue(function ($roles) {
                    return match (true) {
                        in_array('ROLE_ADMIN', $roles) => '<i class="fa-solid fa-user-gear"></i>',
                        in_array('ROLE_USER', $roles) => '<i class="fa-solid fa-user"></i>',
                        default => '',
                    };
                }),
            TextField::new('adrMembre', 'Adresse'),
            TextField::new('villeMembre', 'Ville'),
            TextField::new('CPMembre', 'Code postal'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(IsAdminFilter::new('roles'))
        ;
    }
}
