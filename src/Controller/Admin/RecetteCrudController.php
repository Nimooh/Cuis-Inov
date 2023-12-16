<?php

namespace App\Controller\Admin;

use App\Entity\CategorieRecette;
use App\Entity\Ingredient;
use App\Entity\Recette;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class RecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recette::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomRecette', 'Nom'),
            TimeField::new('tempsRecette', 'Durée')->setFormat('HH:mm:ss'),
            IntegerField::new('diffRecette', 'Difficulté'),
            NumberField::new('noteMoyenne', 'Note Moyenne'),
            TextField::new('description', 'Description'),
            TextareaField::new('instruction', 'Instructions'),
            AssociationField::new('categoriesRecette', 'Catégorie')
                ->setFormTypeOptions([
                    'class' => CategorieRecette::class,
                    'choice_label' => 'nomCatRecette',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('c')
                            ->orderBy('c.nomCatRecette', 'ASC');
                    },
                ]),
            AssociationField::new('composers', 'Ingrédients')
                ->setFormTypeOptions([
                    'class' => Ingredient::class,
                    'choice_label' => 'nomIngr',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('i')
                            ->orderBy('i.nomIngr', 'ASC');
                    },
                ]),
        ];
    }
}
