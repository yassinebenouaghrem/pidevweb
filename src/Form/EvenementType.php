<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idOrganisateur',NumberType::class)
            ->add('type')
            ->add('titre')
            ->add('description')
            ->add('lieu')
            ->add('dateEvent')
            ->add('image')
            ->add('tarif')
            ->add('capacite',NumberType::class)
            ->add('nbReservation',NumberType::class)
            ->add('etat',ChoiceType::class,[
                'choices'=>[
                    'Nouvelle'=>'Nouvelle',
                    'Ancienne'=>'Ancienne'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
