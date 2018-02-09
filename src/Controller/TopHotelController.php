<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TopHotelController extends Controller
{
    /**
     * @Route("/top-hotel", name="top-hotel")
     */
    public function IndexAction()
    {
        return $this->render('top-hotel/index.html.twig', []);
    }
}