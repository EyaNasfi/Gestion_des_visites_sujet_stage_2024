<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UseradminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom',
                ],
            ])
            ->add('prenom', null, [
                'label' => 'prenom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prenom',
                ],
            ])
            ->add('email', null, [
                'label' => 'email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'password',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'ADMIN' => 'ROLE_ADMIN',
                ],
                'expanded' => false,
                'multiple' => true,
                'data' => ['ROLE_ADMIN'], // Default role value
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'form-control btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
