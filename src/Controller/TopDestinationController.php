<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TopDestinationController extends Controller
{
    /**
     * @Route("/top-destination", name="top-destination")
     */
    public function IndexAction()
    {
        return $this->render('top-destination/index.html.twig', []);
    }
}