<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'お名前',
                'required' => true,
                'constraints' => [
                    new Assert\Length(['max' => 255]),
                    new Assert\NotBlank(),
                ],
            ])
            ->add(
                'body',
                TextareaType::class,
                [
                    'label' => '本文', 'required' => true,
                    'constraints' => [
                        new Assert\Length(['max' => 1000]),
                    ],
                ]
            )
            ->add('save', SubmitType::class, ['label' => '登録'])
        ;
    }
}
