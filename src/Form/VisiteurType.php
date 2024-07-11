<?php

namespace App\Form;

use App\Entity\Visiteur;
use App\Entity\TypeVisiteur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\TypeVisiteurRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VisiteurType extends AbstractType
{
    private $typeVisiteurRepository;

    public function __construct(TypeVisiteurRepository $typeVisiteurRepository)
    {
        $this->typeVisiteurRepository = $typeVisiteurRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('cin', null, [
            'label' => 'Cin',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Cin',
            ]
        ])
        
        ->add('idtype', EntityType::class, [
                                                                    'class' => TypeVisiteur::class,
                                                                    'choice_label' => 'contenu',
                                                                    'placeholder' => 'Select a type',
                                                                    'attr' => [
                                                                        'class' => 'form-control select2',
                                                                    ],
                                                                    'query_builder' => function (EntityRepository $repository) {
                                                                        return $repository->createQueryBuilder('tv')
                                                                            ->orderBy('tv.contenu', 'ASC');
                                                                    },
                                                                ])
                                                                ->add('nom',null ,[ 'label' => 'Nom ',

                                                                'attr' => [
                                                                   'class' => 'form-control',
                                                                    'placeholder' => 'Nom',
                                                                   ]     ] ,
                                                                           )
                                                                
                                                                
            ->add('prenom',null ,[ 'label' => 'Prenom ',

                       'attr' => [
                          'class' => 'form-control',
                           'placeholder' => 'Prenom',
                          ]     ] ,
                                  )
               
                        
                                     
            ->add('numtlf',null ,[ 'label' => 'numero de telephone ',
            
                                             'attr' => [
                                                'class' => 'form-control',
                                                 'placeholder' => 'Numero de telephone',
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
            'data_class' => Visiteur::class,
        ]);
    }
}
