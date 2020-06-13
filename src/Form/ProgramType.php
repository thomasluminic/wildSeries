<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Program;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'text-secondary'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('summary', null, [
                'label' => 'Sommaire',
                'label_attr' => [
                    'class' => 'text-secondary'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('poster',null, [
                'label' => 'Poster',
                'label_attr' => [
                    'class' => 'text-secondary'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('category', null, [
                'label' => 'Categorie',
                'label_attr' => [
                    'class' => 'text-secondary'
                ],
                'choice_label' => 'name'
            ])
            ->add('actors', EntityType::class, [
                'label' => 'Acteur',
                'label_attr' => [
                    'class' => 'text-secondary'
                ],
                'class' => Actor::class,
                'choice_label' => 'name',
                'choice_attr' => [
                    'class' => 'form-check-input'
                ],
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
