<?php
/**
 * Created by PhpStorm.
 * User: Stephanichou
 * Date: 05/04/2018
 * Time: 11:09
 */

namespace App\Controller\BackOffice\Admin;

use App\Entity\Hotel;
use App\Form\HotelType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/hotels")
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
     * @Route("/create", name="createHotelAdmin")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createHotelAction(Request $request) {

        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('adminHotels');

        }
        return $this->render('backoffice/admin/hotels/form.html.twig', [
           'hotelForm' => $form->createView(),
        ]);


    }
}