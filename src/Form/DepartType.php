<?php

namespace App\Form;

use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DepartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomdep',null ,[ 'label' => 'Nom de departement  ',

        'attr' => [
           'class' => 'form-control',
            'placeholder' => 'Nom de departement',
           ]     ] ,
                   )
           
        ->add('submit',SubmitType::class, [
            'attr' => [
                'class' => 'form-control btn btn-primary',
            ],
        ])
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departement::class,
        ]);
    }
}
