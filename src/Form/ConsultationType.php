<?php

namespace App\Form;

use App\Entity\Consultation;
use http\Env\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Validator\Constraints\File;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class)
            ->add('description',TextType::class)
          //  ->add('emplacement',TextType::class)
            ->add('emplacement',HiddenType::class,[
                'attr'=>['name'=>'emplacement',
                    'id'=>'emplacement']])
            ->add('prix',NumberType::class)
            ->add('image', FileType::class, array('data_class' => null),[    'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,


            ])
            ->add('date',DateType::class,
                ['data'   => new \DateTime(),
                    'attr' => ['class'=> 'form-control js-datetimepicker','min' => ( new \DateTime() )->format('Y-m-d')],
                    'required' => false,
                    'widget'=> 'single_text',
                ])

            ->add('heuredeb',TimeType::class, [

                'label' => 'Opens',
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'string',
                'with_seconds' => false,
            ])
            ->add('heurefin',TimeType::class, [
                'label' => 'Opens',
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'string',
                'with_seconds' => false,
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
