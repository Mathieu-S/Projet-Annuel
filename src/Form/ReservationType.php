<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, [
                'label' => 'Premier jour de réservation',
                'widget' => 'single_text'
            ])
            ->add('finalDate', DateType::class, [
                'label' => 'Dernier jour de réservation',
                'widget' => 'single_text'
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $currentDate = new \DateTime('now');
                $data = $event->getData();
                if ($data->getStartDate() >= $data->getFinalDate()) {
                    $form->get('finalDate')->addError(new FormError("La date d'arrivée doit forcément être plus tard que la date de départ"));
                }
                if ($data->getStartDate() <= $currentDate) {
                    $form->get('startDate')->addError(new FormError("Vous ne pouvez pas réserver pour une date antérieure à celle d'aujourd'hui"));
                }

            });
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
