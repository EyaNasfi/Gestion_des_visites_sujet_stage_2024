<?php

namespace App\Form;

use App\Entity\Badge;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BadgeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code',null ,[ 'label' => 'Code  ',

            'attr' => [
               'class' => 'form-control',
                'placeholder' => 'Code badge',
               ]     ] ,
                       )
                       ->add('datecreation', DateType::class, [
                        'attr' => [
                            'class' => 'form-control',
                            'placeholder' => 'Date de creation',
                        ],
                    ])
        ->add('datexpiration', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date expiration',
                ],
            ])
            ->add('idetat', EntityType::class, [
                'class' => 'App\Entity\EtatBadge',
                
            'attr' => [
                'class' => 'form-control select2',
            ],
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('tv')
                    ->orderBy('tv.libelle', 'ASC');
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
            'data_class' => Badge::class,
        ]);
    }
}
