<?php

namespace App\Controller\BackOffice\Admin;

use App\Entity\Hotel;
use App\Form\HotelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/hotels")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class HotelController extends Controller
{

    /**
     * @Route("/", name="adminHotels")
     */
    public function HotelsAction()
    {
        $hotels = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Hotel')
            ->findAll();

        return $this->render('backoffice/admin/hotels/hotels.html.twig', [
            'hotels' => $hotels
        ]);
    }

    /**
     * @param Request $request
     * @Route("/create", name="adminCreateHotels")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createHotelAction(Request $request) {

        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hotel->setCreatedAt(new \DateTime());
            $hotel->setOwner($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('adminHotels');

        }
        return $this->render('backoffice/admin/hotels/form.html.twig', [
           'hotelForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="adminEditHotels")
     */
    public function EditHotelAction(Request $request, Hotel $hotel)
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('adminHotels');
        }
        return $this->render('backoffice/admin/hotels/form.html.twig', [
            'hotelForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="adminDeleteHotels")
     */
    public function DeleteHotelAction(Hotel $hotel)
    {
        if ($hotel === null) {
            return $this->redirectToRoute('adminHotels');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($hotel);
        $em->flush();
        return $this->redirectToRoute('adminHotels');
    }
}