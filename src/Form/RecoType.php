<?php

namespace App\Form;

use App\Entity\Reco;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RecoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('ecrivain')
            ->add('image',FileType::class, array('data_class' => null))
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'livre' => 'Livre',
                    'article' => 'Article',
                ],
            ])        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reco::class,
        ]);
    }
}
