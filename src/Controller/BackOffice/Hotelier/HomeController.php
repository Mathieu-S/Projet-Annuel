<?php

namespace App\Controller\BackOffice\Hotelier;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hotelier")
 * @Security("is_granted('ROLE_HOTEL')")
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
