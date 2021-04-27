<?php

namespace App\Form;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\ChoiceList\ChoiceList;

use App\Entity\FitreRecherche;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FitreRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('TypeEvent', ChoiceType::class, [ 'required' => false,
                'placeholder' =>"Choisir le type d'événement",

                    'choices'  => [
                    'Conférence' => 'Conférence',
                    'Cinéma' => 'Cinéma',
                    'Méditation' => 'Méditation',
                    'Musique' => 'Musique',
                    'Randonnée' => 'Randonnée',
                    'Sport et fitness' => 'Sport et fitness',
                 ]] )

            ->add('PrixMax',IntegerType::class,
                ['required' => false,
                    'label'=>false,
                    'attr' => [
                        'placeholder' => 'Rechercher en fonction de votre budget',
                    ],

            ])
            ->add('dateDebut',DateType::class,
                ['required' => false,
                    'attr' => ['class'=> 'form-control' ],
                    'required' => false,
                    'widget'=> 'single_text',
                ]
            )->add('dateFin',DateType::class,
                ['required' => false,
                    'attr' => ['class'=> 'form-control' ],
                    'required' => false,
                    'widget'=> 'single_text',
                ]
            )
/*
           // ->add('lieu')                     return $Evenement->getLieu();
           ->add('lieu', EntityType::class , [
               'class' => Evenement::class ,

               'choice_label' => function ( Evenement $Evenement ) {
                   return sprintf('%s', $Evenement->getLieu());
               },

               ])

*/

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FitreRecherche::class,
            'method'=>'get',
            'csrf_protection'=>false
        ]);
    }
    public  function getBlockPrefix()
    {
return '';
    }
}
