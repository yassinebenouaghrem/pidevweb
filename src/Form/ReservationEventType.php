<?php

namespace App\Form;

use App\Entity\ReservationEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idOrganisateur')
            ->add('idClient')
            ->add('idEvent')
            ->add('nbPlace')
            ->add('total')
            ->add('modePaiement')
            ->add('etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationEvent::class,
        ]);
    }
}
