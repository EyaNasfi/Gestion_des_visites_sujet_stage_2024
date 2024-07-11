<?php

namespace App\Form;

use App\Entity\Badge;
use App\Entity\PersonneVisite;
use App\Entity\Visite;
use App\Entity\Visiteur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType; // Importez DateType ici

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('datevisite', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date de visite',
                ],
            ])
        ->add('heureArrivee',TimeType::class,[ 

            'attr' => [
               'class' => 'form-control',
               ]     ] ,
                       )
        ->add('heureDepart',TimeType::class,[
                       'attr' => [
                          'class' => 'form-control',
                          ]     ] ,
                                  )
            
        ->add('but', null, [
            'label' => 'But de la visite',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'But de la visite',
            ],
        ])
        ->add('idv',EntityType::class, [
            'class' => Visiteur::class,
            'choice_label' => 'nom',
            'placeholder' => 'Selectez le visiteur',
            'attr' => [
                'class' => 'form-control select2',
            ],
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('tv')
                    ->orderBy('tv.nom', 'ASC');
            },
        ])
        ->add('idemployeevisit',EntityType::class, [
            'class' => PersonneVisite::class,
            'choice_label' => 'nomprenom',
            'placeholder' => 'Selectez un employee',
            'attr' => [
                'class' => 'form-control select2',
            ],
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('t')
                    ->orderBy('t.nomprenom', 'ASC');
            },
        ])
        ->add('idbadge', EntityType::class, [
            'class' => Badge::class,
            'choice_label' => 'code',
            'placeholder' => 'Select a type',
            'attr' => [
                'class' => 'form-control select2',
            ],
            'query_builder' => function (EntityRepository $repository) {
    return $repository->createQueryBuilder('ttv')
        ->where('ttv.idetat = :idba')
        ->setParameter('idba', 2)
        ->orderBy('ttv.idba', 'ASC');
},])
        ->add('submit', SubmitType::class, [
            'label' => 'Enregistrer',
            'attr' => [
                'class' => 'form-control btn btn-primary',
            ],
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
