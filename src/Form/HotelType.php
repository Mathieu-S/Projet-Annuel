<?php

namespace App\Form;

use App\Entity\Hotel;
use App\Entity\PostalCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{

    private $postalCodeRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->postalCodeRepository = $entityManager->getRepository(PostalCode::class);
    }

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
            ->add('postalCode', ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'placeholder' => "Code postal",
                'choice_loader' => new CallbackChoiceLoader(function () {
                    $postalCodes = $this->postalCodeRepository->findPostalCodesFromAquitaine();
                    $choices = [];
                    foreach ($postalCodes as $postalCode) {
                        $choices[$postalCode["code"]] = $postalCode["id"];
                    }
                    return $choices;
                })
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Hotel::class
        ]);
    }
}
