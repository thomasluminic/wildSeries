<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextareaType::class, [
                'label' => "Commentaire",
                'label_attr' => [
                    'class' => 'text-secondary'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('rate', IntegerType::class, [
                'label' => "Note",
                'label_attr' => [
                    'class' => 'text-secondary'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'max' => 5,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
