<?php

namespace App\Controller\BackOffice\Contact;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/bo/contacts-requests")
 * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN'])")
 */
class ContactController extends Controller
{

    /**
     * @Route("/", name="indexContactRequests")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function ContactsIndexAllAction()
    {
        $contactRequests = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Contact')
            ->findAll();

        return $this->render('backoffice/common/contacts/index.html.twig', [
            'contactRequests' => $contactRequests
        ]);
    }

}