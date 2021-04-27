<?php

namespace App\Form;

use App\Entity\ReservationEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Evenement;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbPlace')


            ->add('modePaiement', ChoiceType::class, [
                'choices'  => [
                    "Sur place" => "Sur place",
                    "En ligne" => "En ligne",
                ] ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationEvent::class,
        ]);
    }

}
