<?php

namespace App\Form;

use App\Entity\Hotelier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'register.lastname'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'register.firstname'
            ])
            ->add('email', EmailType::class, [
                'label' => 'register.email'
            ])
            ->add('siren', NumberType::class, [
                'label' => 'register.siren'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'register.password'],
                'second_options' => ['label' => 'register.password.repeat']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Hotelier::class
        ]);
    }
}
