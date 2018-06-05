<?php

namespace App\Controller\BackOffice\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class HomeController extends Controller
{
    /**
     * @Route("/home", name="adminHome")
     */
    public function IndexAction()
    {
        return $this->render('backoffice/admin/index.html.twig', [
            'selectedMenu' => 'accueil'
        ]);
    }
}
