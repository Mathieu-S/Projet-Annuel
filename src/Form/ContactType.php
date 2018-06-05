<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Hotelier;
use App\Entity\User;
use App\Repository\HotelierRepository;
use App\Repository\HotelRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{

    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $currentUserId = $options['current_user_id'];
        $currentUser = $this->userRepository->findOneBy(['id' => $currentUserId]);

        $builder
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'constraints' => array(
                    new NotBlank(["message" => "Le sujet du message est obligatoire"]),
                ),
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'constraints' => array(
                    new NotBlank(["message" => "Le contenu du message est obligatoire"]),
                ),
            ]);
            if ($currentUser->getRoles()[0] == "ROLE_ADMIN" || $currentUser->getRoles()[0] == "ROLE_HOTEL") {
                $builder->add('receiver', EntityType::class, [
                    'label' => 'A qui voulez-vous envoyer ce message ?',
                    'class' => 'App\Entity\User',
                    'query_builder' => function (UserRepository $ur) use ($currentUserId) {
                        return $ur->createQueryBuilder('u')
                            ->where('u.id != :value')->setParameter('value', $currentUserId);
                    },
                    'choice_label' => function (User $user) {
                        return $user->getEmail();
                    }
                ]);
            } else {
                $builder->add('receiver', EntityType::class, [
                    'label' => 'A qui voulez-vous envoyer ce message ?',
                    'class' => 'App\Entity\Hotelier',
                    'query_builder' => function (HotelierRepository $hr) use ($currentUserId) {
                        return $hr->createQueryBuilder('h')
                            ->where('h.id != :value')->setParameter('value', $currentUserId);
                    },
                    'choice_label' => function (User $user) {
                        return $user->getEmail();
                    }
                ]);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Contact::class,
            'current_user_id' => null
        ]);
    }
}
