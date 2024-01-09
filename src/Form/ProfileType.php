<?php

namespace App\Form;

use App\Entity\Allergene;
use App\Entity\Membre;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'empty_data' => '',
            ])
            ->add('password', PasswordType::class, [
                'hash_property_path' => 'password',
                'mapped' => false,
                'empty_data' => '',
            ])
            ->add('nomMembre', TextType::class, [
                'required' => true,
                'empty_data' => '',
            ])
            ->add('prnmMembre', TextType::class, [
                'required' => true,
                'empty_data' => '',
            ])
            ->add('telMembre', TelType::class, [
                'required' => true,
                'empty_data' => '',
            ])
            ->add('allergenes', EntityType::class, [
                'class' => Allergene::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('a')
                        ->orderBy('a.nomAller', 'ASC');
                },
                'choice_label' => 'nomAller',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
