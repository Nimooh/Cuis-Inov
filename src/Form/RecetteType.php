<?php

namespace App\Form;

use App\Entity\CategorieRecette;
use App\Entity\Recette;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRecette', TextType::class, [
                    'empty_data' => '',
                ]
            )
            ->add('nbPers', IntegerType::class, [
                'empty_data' => '',
            ])
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
                    'attr' => ['min'=>1,'max'=>3],
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
            ->add('categoriesRecette', EntityType::class, [
                'class' => CategorieRecette::class,
                'choice_label' => 'nomCatRecette',
                'multiple' => true,
                'expanded' => true,
                'placeholder' => 'Catégories',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->orderBy('c.nomCatRecette', 'ASC');
                },
            ])
            ->add('composers', CollectionType::class, [
                'entry_type' => ComposerType::class,
                'entry_options' => ['label' => false],
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de transmettre une image au format PNG',
                    ]),
                ],
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
