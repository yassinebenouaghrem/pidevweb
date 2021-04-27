<?php

namespace App\Form;

use App\Entity\User;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin',NumberType::class,[
                'attr'=>[
                    'placeholder'=>'cin'

                    ]
            ])
            ->add('email',EmailType::class,[
                'attr'=>[
                    'placeholder'=>'email'

                ]
            ])
            ->add('nom',TextType::class,[
                'attr'=>[
                    'placeholder'=>'nom'

                ]
            ])
            ->add('prenom',TextType::class,[  'attr'=>[
                'placeholder'=>'prenom'

            ]])
            ->add('password',PasswordType::class,[
                'attr'=>[
                    'placeholder'=>'password'

                ]
            ])
            ->add('captcha',CaptchaType::class,[

            ])
            ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
