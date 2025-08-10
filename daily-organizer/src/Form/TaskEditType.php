<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'input input-bordered'],
            ])
            ->add('dueDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'input input-bordered'],
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'to do' => 'to do',
                    'in progress' => 'in progress',
                    'done' => 'done',
                ],
                'attr' => ['class' => 'select select-bordered'],
            ])
            ->add('category', TextType::class, [
                'attr' => ['class' => 'input input-bordered'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => null,
        ]);
    }
}
