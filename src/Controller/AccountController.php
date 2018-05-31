<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/account")
 * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN', 'ROLE_USER'])")
 */
class AccountController extends Controller
{
    /**
     * @Route("/user/{id}", name="personalDataAccount")
     */
    public function UserDataAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $userId = $request->attributes->get('id');
        $user = $em
            ->getRepository('App:User')
            ->findOneBy(['id' => $userId]);

        return $this->render('account/personal-data.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/reservation/{id}", name="reservationDataAccount")
     */
    public function ReservationDataAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $userId = $request->attributes->get('id');
        $reservations = $em
            ->getRepository('App:Reservation')
            ->findBy(['user' => $userId]);
        return $this->render('account/reservation.html.twig', [
            'reservations' => $reservations
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="editUserData", requirements={"page": "[1-9]\d*"})
     */
    public function EditUserDataAction(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm('App\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('personalDataAccount', ['id' => $user->getId()]);
        }

        return $this->render('account/user-form.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

}