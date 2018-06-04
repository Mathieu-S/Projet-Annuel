<?php

namespace App\Controller\BackOffice\Reservation;

use App\Entity\Hotel;
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
            'reservations' => $reservations,
            'selectedMenu' => 'reservation'
        ]);
    }

    /**
     * @Route("/hotel/{id}", name="indexReservationsHotel", requirements={"page": "[1-9]\d*"})
     */
    public function HotelReservationsAction(Request $request)
    {
        $hotelierId = $request->attributes->get('id');
        $reservations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Reservation')
            ->getOwnerReservations($hotelierId);

        return $this->render('backoffice/common/reservations/index.html.twig', [
            'reservations' => $reservations,
            'selectedMenu' => 'reservation'
        ]);
    }

}