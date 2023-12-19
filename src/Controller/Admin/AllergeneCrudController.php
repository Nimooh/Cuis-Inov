<?php

namespace App\Controller\Admin;

use App\Entity\Allergene;
use App\Entity\Ingredient;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AllergeneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Allergene::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomAller', 'Nom'),
            AssociationField::new('ingredients', 'Ingrédients')
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
