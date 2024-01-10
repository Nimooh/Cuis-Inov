<?php

namespace App\Controller\Admin;

use App\Admin\Field\DateIntervalField;
use App\Entity\CategorieRecette;
use App\Entity\Recette;
use App\Form\ComposerType;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            IntegerField::new('nbPers', 'Nombre de personnes'),
            DateIntervalField::new('tempsRecette', 'Durée'),
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
            CollectionField::new('composers', 'Ingrédients')
                ->setEntryType(ComposerType::class)
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->allowAdd(true)
                ->allowDelete(true),
            ImageField::new('picturePath', 'Illustration')
                ->setBasePath('img/recettes/')
                ->setUploadDir('public/img/recettes/'),
        ];
    }
}
