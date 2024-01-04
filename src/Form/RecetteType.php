<?php

namespace App\Form;

use App\Entity\CategorieRecette;
use App\Entity\Ingredient;
use App\Entity\Recette;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRecette', TextType::class, [
                    'empty_data' => '',
                ]
            )
            ->add('tempsRecette', DateIntervalType::class, [
                    'widget' => 'integer',
                    'with_years' => false,
                    'with_months' => false,
                    'with_days' => false,
                    'with_minutes' => true,
                ]
            )
            ->add('diffRecette', IntegerType::class, [
                    'empty_data' => '',
                ]
            )
            ->add('instruction', TextareaType::class, [
                    'empty_data' => '',
                ]
            )
            ->add('description', TextType::class, [
                    'empty_data' => '',
                ]
            )
            ->add('noteMoyenne', NumberType::class, [
                    'empty_data' => '',
                ]
            )
            ->add('categoriesRecette', EntityType::class, [
                'class' => CategorieRecette::class,
                'choice_label' => 'nomCatRecette',
                'required' => false,
                'multiple' => true,
                'placeholder' => 'Catégories',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->orderBy('c.nomCatRecette', 'ASC');
                },
            ])
            ->add('composers', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'nomIngr',
                'required' => false,
                'multiple' => true,
                'placeholder' => 'Ingredients',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('i')
                        ->orderBy('i.nomIngr', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
