<?php

namespace App\Controller\Admin;

use App\Entity\CategorieRecette;
use App\Entity\Recette;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieRecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorieRecette::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomCatRecette', 'Nom'),
            AssociationField::new('recettes', 'Recettes')
                ->setFormTypeOptions([
                    'class' => Recette::class,
                    'choice_label' => 'nomRecette',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('r')
                            ->orderBy('r.nomRecette', 'ASC');
                    },
                ]),
        ];
    }
}
