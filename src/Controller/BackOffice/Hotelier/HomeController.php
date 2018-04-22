<?php

namespace App\Controller\BackOffice\Hotelier;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hotelier")
 */
class HomeController extends Controller
{
    /**
     * @Route("/home", name="hotelierHome")
     */
    public function IndexAction()
    {
        return $this->render('backoffice/hotelier/index.html.twig', []);
    }
}
