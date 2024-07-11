<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\PersonneVisite;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomprenom',null ,[ 'label' => 'nometprenomdeemployee ',
        'attr' => [
           'class' => 'form-control',
            'placeholder' => 'nom et prenom de employee',
           ]     ] ,
                   )
         ->add('metier',null ,[ 'label' => 'metier ',
        'attr' => [
           'class' => 'form-control',
            'placeholder' => 'metier',
           ]     ] ,
                   )
        ->add('iddep', EntityType::class, [
            'class' => Departement::class,
            'choice_label' => 'nomdep',
            'placeholder' => 'Select a type',
            'attr' => [
                'class' => 'form-control select2',
            ],
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('ttv')
                    ->orderBy('ttv.nomdep', 'ASC');
            },
        ])
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
            'data_class' => PersonneVisite::class,
        ]);
    }
}
