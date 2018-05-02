<?php

namespace App\Controller\BackOffice\Hotelier;

use App\Entity\BedRoom;
use App\Entity\Hotel;
use App\Form\BedRoomType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/create", name="hotelierCreateHotelChambers")
     */
    public function CreateHotelChambersAction(Request $request)
    {
        $bedRoom = new BedRoom();
        $form = $this->createForm(BedRoomType::class, $bedRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bedRoom->setAvailability(true);
//            $bedRoom->set($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($bedRoom);
            $em->flush();
            return $this->redirectToRoute('hotelierHome');

        }
        return $this->render('backoffice/hotelier/chambres/form.html.twig', [
            'bedRoomForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="hotelierEditHotels")
     */
    public function EditHotelChambersAction(Request $request, Hotel $hotel)
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('hotelierHome');
        }
        return $this->render('backoffice/hotelier/hotels/form.html.twig', [
            'hotelForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="hotelierDeleteHotels")
     */
    public function DeleteHotelChambersAction(Hotel $hotel)
    {
        if ($hotel === null) {
            return $this->redirectToRoute('hotelierHome');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($hotel);
        $em->flush();
        return $this->redirectToRoute('hotelierHome');
    }
}
