<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @Route("/account/{id}", name="indexAccount")
     * @Security("is_granted(['ROLE_HOTEL', 'ROLE_ADMIN', 'ROLE_USER'])")
     */
    public function IndexAction(Request $request)
    {


    }


}