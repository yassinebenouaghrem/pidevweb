<?php

namespace App\Form;

use App\Entity\Paniers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaniersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin',NumberType::class)

            ->add('statusPanier',ChoiceType::class,[
                'choices'=>[
                    "Concernant l'utilisateur"=>[
                        'Abondonner'=>'Abondonner',
                        'En cours'=>'En cours',
                        'Payer'=>'Payer',
                    ],
                    "Concernat la livraison"=>[
                        'Livrer'=>'Livrer',
                    ],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paniers::class,
        ]);
    }
}
