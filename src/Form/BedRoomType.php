<?php

namespace App\Form;

use App\Entity\BedRoom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BedRoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'bedRoom.description'
            ])
            ->add('price', MoneyType::class, [
                'label' => 'bedRoom.price'
            ])
            ->add('options', EntityType::class, [
                'label' => 'bedRoom.options',
                'class' => 'App\Entity\OptionalEquipment',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('images', CollectionType::class, [
                'label' => false,
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BedRoom::class,
        ]);
    }
}
