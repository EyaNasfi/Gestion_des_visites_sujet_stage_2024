<?php

namespace App\Form;

use App\Entity\EtatBadge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EtatbadgeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libelle',null ,[ 'label' => 'Etat de badge  ',

        'attr' => [
           'class' => 'form-control',
            'placeholder' => 'Type',
           ]     ] ,
                   )
           
        ->add('submit',SubmitType::class, [
            'attr' => [
                'class' => 'form-control btn btn-primary',
            ],
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtatBadge::class,
        ]);
    }
}
