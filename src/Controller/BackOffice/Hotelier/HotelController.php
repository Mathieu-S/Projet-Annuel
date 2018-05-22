<?php

namespace App\Controller\BackOffice\Hotelier;

use App\Entity\Hotel;
use App\Form\HotelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hotelier/hotels")
 * @Security("is_granted('ROLE_HOTEL')")
 */
class HotelController extends Controller
{
    /**
     * @param Request $request
     * @Route("/create", name="hotelierCreateHotels")
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
            $file = $hotel->getImage()->getUri();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $hotel->getImage()->setUri($fileName);
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('hotelierHome');

        }
        return $this->render('backoffice/admin/hotels/form.html.twig', [
            'hotelForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="hotelierEditHotels")
     */
    public function EditHotelAction(Request $request, Hotel $hotel)
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
    public function DeleteHotelAction(Hotel $hotel)
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