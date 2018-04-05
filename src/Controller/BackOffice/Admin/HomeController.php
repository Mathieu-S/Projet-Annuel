<?php

namespace App\Controller\BackOffice\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class HomeController extends Controller
{
    /**
     * @Route("/home", name="adminHome")
     */
    public function IndexAction()
    {
        return $this->render('backoffice/admin/index.html.twig', []);
    }

    /**
     * @Route("/users", name="adminUsers")
     */
    public function UsersAction()
    {
        $users = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:User')
            ->findAll();

        return $this->render('backoffice/admin/users.html.twig', [
            'users' => $users
        ]);
    }
}
