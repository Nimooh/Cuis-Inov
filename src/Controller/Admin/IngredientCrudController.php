<?php

namespace App\Controller\Admin;

use App\Entity\Allergene;
use App\Entity\Ingredient;
use App\Entity\Recette;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingredient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomIngr', 'Nom'),
            AssociationField::new('allergenes', 'Allergènes')
                ->setFormTypeOptions([
                    'class' => Allergene::class,
                    'choice_label' => 'nomAller',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('a')
                            ->orderBy('a.nomAller', 'ASC');
                    },
                ]),
            AssociationField::new('composers', 'Recettes')
                ->setFormTypeOptions([
                    'class' => Recette::class,
                    'choice_label' => 'nomRecette',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('r')
                            ->orderBy('r.nomRecette', 'ASC');
                    },
                ])
            ->hideOnForm(),
            ImageField::new('picturePath', 'Illustration')
                ->setBasePath('img/ingredients/')
                ->setUploadDir('public/img/ingredients/'),
        ];
    }
}
