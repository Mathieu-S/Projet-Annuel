<?php

namespace App\Controller\BackOffice\Reservation;

use App\Entity\Reservation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/bo/reservations")
 * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN'])")
 */
class ReservationController extends Controller
{

    /**
     * @Route("/", name="indexReservations")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function ReservationsAction()
    {
        $reservations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Reservation')
            ->findAll();

        return $this->render('backoffice/common/reservations/index.html.twig', [
            'reservations' => $reservations
        ]);
    }

}