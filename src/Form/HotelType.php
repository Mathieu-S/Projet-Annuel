<?php

namespace App\Form;

use App\Entity\Hotel;
use App\Repository\CityRepository;
use App\Repository\DepartmentRepository;
use App\Repository\PostalCodeRepository;
use App\Repository\RegionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class HotelType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'register.name',
                'constraints' => array(
                    new NotBlank(["message" => "Le nom de l'hôtel est obligatoire"]),
                ),
            ])
            ->add('address', TextType::class, [
                'label' => 'register.address',
                'constraints' => array(
                    new NotBlank(["message" => "L'adresse de l'hôtel est obligatoire"]),
                ),
            ])
            ->add('email', EmailType::class, [
                'label' => 'register.email'
            ])
            ->add('description', TextType::class, [
                'label' => 'register.description',
                'constraints' => array(
                    new NotBlank(["message" => "La description de l'hôtel est obligatoire"]),
                ),
            ])
            ->add('region', EntityType::class, [
                'label' => 'Région',
                'class' => 'App\Entity\Region',
                'query_builder' => function (RegionRepository $rr) {
                    return $rr->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
                'choice_label' => 'name',
                'constraints' => array(
                    new NotBlank(["message" => "La région de l'hôtel est obligatoire"]),
                ),

            ])
            ->add('department', EntityType::class, [
                'label' => 'Département',
                'class' => 'App\Entity\Department',
                'choice_label' => 'name',
                'query_builder' => function (DepartmentRepository $dr) {
                    return $dr->findDepartmentsFromAquitaine();
                },
                'constraints' => array(
                    new NotBlank(["message" => "Le département de l'hôtel est obligatoire"]),
                ),

            ])
            ->add('city', EntityType::class, [
                'label' => 'Ville',
                'class' => 'App\Entity\City',
                'choice_label' => 'name',
                'query_builder' => function (CityRepository $cr) {
                    return $cr->findCitiesFromAquitaine();
                },
                'constraints' => array(
                    new NotBlank(["message" => "La ville de l'hôtel est obligatoire"]),
                ),
            ])
            ->add('postalCode', EntityType::class, [
                'label' => 'Code postal',
                'class' => 'App\Entity\PostalCode',
                'query_builder' => function (PostalCodeRepository $pcr) {
                    return $pcr->findPostalCodesFromAquitaine();
                },
                'choice_label' => 'code',
                'constraints' => array(
                    new NotBlank(["message" => "Le code postal de l'hôtel est obligatoire"]),
                ),
            ])
            ->add('images', CollectionType::class, [
                'label' => false,
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
            ])
            ->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {

                // Get the parent form
                $form = $event->getForm();
                $departmentId = false;
                $cityId = false;
                $postalCodeId = false;

                if (isset($event->getData()['department'])) {
                    $departmentId = $event->getData()['department'];
                }
                if (isset($event->getData()['city'])) {
                    $cityId = $event->getData()['city'];
                }
                if (isset($event->getData()['postalCode'])) {
                    $postalCodeId = $event->getData()['postalCode'];
                }

                // Add the field again, with the new choices :
                $form->add('department', EntityType::class,
                    [
                        'query_builder' => function (DepartmentRepository $dr) use ($departmentId) {
                        return $dr->createQueryBuilder('d')
                            ->where("d.id = :departmentId")
                            ->setParameter('departmentId', $departmentId);
                        },
                        'class' => 'App\Entity\Department',
                        'constraints' => array(
                            new NotBlank(["message" => "Le département de l'hôtel est obligatoire"]),
                        ),
                    ]
                )
                ->add('city', EntityType::class,
                    [
                        'query_builder' => function (CityRepository $cr) use ($cityId) {
                            return $cr->createQueryBuilder('c')
                                ->where("c.id = :cityId")
                                ->setParameter('cityId', $cityId);
                        },
                        'class' => 'App\Entity\City',
                        'constraints' => array(
                            new NotBlank(["message" => "La ville de l'hôtel est obligatoire"]),
                        ),
                    ]
                )
                    ->add('postalCode', EntityType::class,
                        [
                            'query_builder' => function (PostalCodeRepository $pcr) use ($postalCodeId) {
                                return $pcr->createQueryBuilder('pc')
                                    ->where("pc.id = :postalCodeId")
                                    ->setParameter('postalCodeId', $postalCodeId);
                            },
                            'class' => 'App\Entity\PostalCode',
                            'constraints' => array(
                                new NotBlank(["message" => "Le code postal de l'hôtel est obligatoire"]),
                            ),
                        ]
                    );
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Hotel::class
        ]);
    }
}
