<?php

namespace App\Controller\BackOffice\Hotelier;

use App\Entity\Hotel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hotelier/chambres")
 * @Security("is_granted('ROLE_HOTEL')")
 */
class ChambreController extends Controller
{
    /**
     * @Route("/all", name="hotelierChambres")
     */
    public function AllChambersAction()
    {
        $chambres = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:BedRoom')
            ->findAll();

        return $this->render('backoffice/hotelier/chambres/chambres.html.twig', [
            'chambres' => $chambres
        ]);
    }

    /**
     * @Route("/hotel/{id}", name="hotelierChambresHotel", requirements={"page": "[1-9]\d*"})
     */
    public function HotelChambersAction(Hotel $hotel)
    {
        $chambres = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:BedRoom')
            ->findAll();

        return $this->render('backoffice/hotelier/chambres/chambres-hotel.html.twig', [
            'chambres' => $chambres,
            'hotel' => $hotel
        ]);
    }
}
