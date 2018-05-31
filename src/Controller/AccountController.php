<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

}