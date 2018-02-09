<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function IndexAction()
    {
        return $this->render('contact/index.html.twig', []);
    }
}