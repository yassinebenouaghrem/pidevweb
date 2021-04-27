<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('type', ChoiceType::class, [
        'choices'  => [
            'Conférence' => 'Conférence',
            'Cinéma' => 'Cinéma',
            'Méditation' => 'Méditation',
            'Musique' => 'Musique',
            'Randonnée' => 'Randonnée',
            'Sport et fitness' => 'Sport et fitness',
        ] ])
            ->add('titre')
            ->add('description', TextareaType::class , [ 'attr' => ['rows'=> 5]])
            ->add('lieu',HiddenType::class,[
                'attr'=>['name'=>'lieu',
                    'id'=>'lieu']])
            ->add('dateEvent',DateType::class,
                [
                    'attr' => ['class'=> 'form-control js-datetimepicker','min' => ( new \DateTime() )->format('Y-m-d')],
                    'required' => false,
                    'widget'=> 'single_text',
                ]
            )

            ->add('image',FileType::class, array('data_class' => null))
            ->add('tarif')
            ->add('capacite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }

    public  function getBlockPrefix()
    {
        return '';
    }
}
