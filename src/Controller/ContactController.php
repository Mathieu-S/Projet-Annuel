<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN', 'ROLE_USER'])")
 */
class ContactController extends Controller
{
    /**
     * @Route("/create", name="createContact")
     */
    public function CreateAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $contact = new Contact();

        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            $dateNow = new \DateTime('now');
            $contact->setCreatedAt($dateNow);
            $contact->setSender($this->getUser());

            $em->persist($contact);
            $em->flush();
            return $this->render('home/index.html.twig', [
            ]);
        }

        return $this->render('contact/form.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);

    }
}