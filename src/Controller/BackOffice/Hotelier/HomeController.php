<?php

namespace App\Controller\BackOffice\Hotelier;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hotelier")
 * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN'])")
 */
class HomeController extends Controller
{
    /**
     * @Route("/home", name="hotelierHome")
     */
    public function IndexAction()
    {
        $hotels = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Hotel')
            ->getOwnerHotels($this->getUser());

        return $this->render('backoffice/common/hotels/index.html.twig', [
            'hotels' => $hotels
        ]);
    }
}
