<?php

namespace App\Controller;

use App\Entity\BedRoom;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends Controller
{
    /**
     * @Route("/reservation/{id}", name="create_reservation")
     * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN', 'ROLE_USER'])")
     */
    public function CreateAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $bedRoomId = $request->attributes->get('id');
        $bedRoom = $em
            ->getRepository('App:BedRoom')
            ->findOneBy(['id' => $bedRoomId]);
        $reservation = new Reservation();

        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        $reservationForm->handleRequest($request);

        if ($reservationForm->isSubmitted() && $reservationForm->isValid()) {

            $reservation->setBedRoom($bedRoom)
                        ->setUser($this->getUser());
            $bedRoom->setAvailability(false);
            $dateNow = new \DateTime('now');
            $reservation->setcreatedAt($dateNow);
            $reservation->setPrice($reservation->getNbOfPersons() * $bedRoom->getPrice());
            $em->persist($reservation);
            $em->flush();
            return $this->render('home/index.html.twig', [
                'bedRoom' => $bedRoom,
                'reservationForm' => $reservationForm->createView()
            ]);
        }

        return $this->render('reservation/form.html.twig', [
            'bedRoom' => $bedRoom,
            'reservationForm' => $reservationForm->createView()
        ]);
    }
}