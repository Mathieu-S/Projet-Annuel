<?php

namespace App\Form;

use App\Entity\BedRoom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BedRoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'register.description',
                'constraints' => array(
                    new NotBlank(["message" => "La description de la chambre est obligatoire"]),
                ),
            ])
            ->add('price', MoneyType::class, [
                'label' => 'register.price',
                'constraints' => array(
                    new NotBlank(["message" => "Le prix de la chambre est obligatoire"]),
                ),
            ])
            ->add('options', EntityType::class, [
                'label' => 'register.options',
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
            ->add('nbOfPersonsMax', IntegerType::class, [
                'label' => 'register.nbOfPersonsMax',
                'constraints' => array(
                    new NotBlank(["message" => "Veuillez renseigner le nombres de places de la chambre"]),
                )
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
