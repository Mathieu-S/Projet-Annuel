<?php

namespace App\Controller\BackOffice\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class HomeController extends Controller
{
    /**
     * @Route("/home", name="adminHome")
     */
    public function IndexAction()
    {
        return $this->render('backoffice/admin/index.html.twig', []);
    }

    /**
     * @Route("/hotels", name="adminHotels")
     */
    public function HotelsAction()
    {
        $hotels = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Hotel')
            ->findAll();

        return $this->render('backoffice/admin/hotels.html.twig', [
            'hotels' => $hotels
        ]);
    }
}
