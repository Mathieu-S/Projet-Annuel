<?php

namespace App\Controller\BackOffice\Hotel;

use App\Entity\Hotel;
use App\Form\HotelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/bo/hotels")
 * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN'])")
 */
class HotelController extends Controller
{

    /**
     * @Route("/", name="indexHotels")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function HotelsAction()
    {
        $hotels = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Hotel')
            ->findAll();

        return $this->render('backoffice/common/hotels/index.html.twig', [
            'hotels' => $hotels
        ]);
    }

    /**
     * @param Request $request
     * @Route("/create", name="createHotel")
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

            $attachments = $hotel->getImages();

            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $file = $attachment->getUri();

                    $filename = md5(uniqid()) . '.' . $file[0]->guessExtension();

                    $file[0]->move(
                        $this->getParameter('images_directory'), $filename
                    );

                    $attachment->setUri($filename);
                    $attachment->setHotel($hotel);
                }
            }

            $em->persist($hotel);
            $em->flush();
            if ($this->getUser()->getRoles()[0] === "ROLE_ADMIN") {
                return $this->redirectToRoute('indexHotels');
            } elseif ($this->getUser()->getRoles()[0] === "ROLE_HOTEL") {
                return $this->redirectToRoute('hotelierHome');
            }

        }
        return $this->render('backoffice/common/hotels/form.html.twig', [
           'hotelForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="editHotel")
     */
    public function EditHotelAction(Request $request, Hotel $hotel)
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $attachments = $hotel->getImages();

            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $file = $attachment->getUri();

                    $filename = md5(uniqid()) . '.' . $file[0]->guessExtension();

                    $file[0]->move(
                        $this->getParameter('images_directory'), $filename
                    );

                    $attachment->setUri($filename);
                    $attachment->setHotel($hotel);
                }
            }
            $em->flush();
            if ($this->getUser()->getRoles()[0] === "ROLE_ADMIN") {
                return $this->redirectToRoute('indexHotels');
            } elseif ($this->getUser()->getRoles()[0] === "ROLE_HOTEL") {
                return $this->redirectToRoute('hotelierHome');
            }
        }
        return $this->render('backoffice/common/hotels/form.html.twig', [
            'hotelForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteHotel")
     */
    public function DeleteHotelAction(Hotel $hotel)
    {
        if ($hotel === null) {
            return $this->redirectToRoute('indexHotels');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($hotel);
        $em->flush();
        return $this->redirectToRoute('indexHotels');
    }

}