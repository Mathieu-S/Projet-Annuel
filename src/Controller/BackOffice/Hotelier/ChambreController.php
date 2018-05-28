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
 * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN'])")
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
            ->findBy(['hotel' => $hotel->getId()]);

        return $this->render('backoffice/hotelier/chambres/chambres-hotel.html.twig', [
            'chambres' => $chambres,
            'hotel' => $hotel
        ]);
    }

    /**
     * @Route("/create/{id}", name="hotelierCreateHotelChambers")
     */
    public function CreateHotelChambersAction(Request $request, Hotel $hotel)
    {
        $bedRoom = new BedRoom();
        $form = $this->createForm(BedRoomType::class, $bedRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bedRoom->setAvailability(true);
            $bedRoom->setHotel($hotel);
            $em = $this->getDoctrine()->getManager();
            $em->persist($bedRoom);
            $em->flush();
            return $this->redirectToRoute('hotelierChambresHotel', ['id' => $hotel->getId()]);

        }
        return $this->render('backoffice/hotelier/chambres/form.html.twig', [
            'bedRoomForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="hotelierEditHotelChambers")
     */
    public function EditHotelChambersAction(Request $request, BedRoom $bedRoom)
    {
        $form = $this->createForm(BedRoomType::class, $bedRoom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('hotelierChambresHotel', ['id' => $bedRoom->getHotel()->getId()]);
        }
        return $this->render('backoffice/hotelier/chambres/form.html.twig', [
            'bedRoomForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/delete/{id}", name="hotelierDeleteHotelChambers")
     */
    public function DeleteHotelChambersAction(BedRoom $bedRoom)
    {
        if ($bedRoom === null) {
            return $this->redirectToRoute('hotelierChambresHotel', ['id' => $bedRoom->getHotel()->getId()]);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($bedRoom);
        $em->flush();
        return $this->redirectToRoute('hotelierChambresHotel', ['id' => $bedRoom->getHotel()->getId()]);
    }
}
