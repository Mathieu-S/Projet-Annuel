<?php

namespace App\Form;

use App\Entity\Hotel;
use App\Repository\CityRepository;
use App\Repository\DepartmentRepository;
use App\Repository\PostalCodeRepository;
use App\Repository\RegionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'register.name'
            ])
            ->add('address', TextType::class, [
                'label' => 'register.address'
            ])
            ->add('email', EmailType::class, [
                'label' => 'register.email'
            ])
            ->add('description', TextType::class, [
                'label' => 'register.description'
            ])
            ->add('region', EntityType::class, [
                'label' => 'Région',
                'class' => 'App\Entity\Region',
                'query_builder' => function (RegionRepository $rr) {
                    return $rr->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
                'choice_label' => 'name'

            ])
            ->add('department', EntityType::class, [
                'label' => 'Département',
                'class' => 'App\Entity\Department',
                'choice_label' => 'name',
                'query_builder' => function (DepartmentRepository $dr) {
                    return $dr->findDepartmentsFromAquitaine();
                }

            ])
            ->add('city', EntityType::class, [
                'label' => 'Ville',
                'class' => 'App\Entity\City',
                'choice_label' => 'name',
                'query_builder' => function (CityRepository $cr) {
                    return $cr->findCitiesFromAquitaine();
                }
            ])
            ->add('postalCode', EntityType::class, [
                'label' => 'Code postal',
                'class' => 'App\Entity\PostalCode',
                'query_builder' => function (PostalCodeRepository $pcr) {
                    return $pcr->findPostalCodesFromAquitaine();
                },
                'choice_label' => 'code'
            ])
            ->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {

                // Get the parent form
                $form = $event->getForm();
                $departmentId = false;
                $cityId = false;

                if (isset($event->getData()['department'])) {
                    $departmentId = $event->getData()['department'];
                }
                if (isset($event->getData()['city'])) {
                    $cityId = $event->getData()['city'];
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
