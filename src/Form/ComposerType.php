<?php

namespace App\Form;

use App\Entity\Composer;
use App\Entity\Ingredient;
use App\Entity\Unite;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qte', NumberType::class, [
                'label' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-s-lg block w-14 p-2.5 text-center',
                ],
            ])
            ->add('ingredient', EntityType::class, [
                'label' => false,
                'class' => Ingredient::class,
                'choice_label' => 'nomIngr',
                'empty_data' => '',
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm block w-full grow p-2.5',
                ],
                'placeholder' => '',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('i')
                        ->orderBy('i.nomIngr', 'ASC');
                },
            ])
            ->add('unite', EntityType::class, [
                'label' => false,
                'class' => Unite::class,
                'choice_label' => 'nomUnit',
                'empty_data' => '',
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-e-lg block p-2.5',
                ],
                'placeholder' => '',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('u')
                        ->orderBy('u.nomUnit', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Composer::class,
        ]);
    }
}
