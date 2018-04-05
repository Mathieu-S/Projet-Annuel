<?php

namespace App\Controller\BackOffice\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/admin/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="adminUsers")
     */
    public function UsersAction()
    {
        $users = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:User')
            ->findAll();

        return $this->render('backoffice/admin/users/list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/edit/{id}", name="adminEditUsers", requirements={"page": "[1-9]\d*"})
     */
    public function EditUserAction(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm('App\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('adminUsers');
        }

        return $this->render('backoffice/admin/users/form.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="adminDeleteUsers", requirements={"page": "[1-9]\d*"})
     */
    public function DeleteUserAction(User $user)
    {
        if ($user === null) {
            return $this->redirectToRoute('adminUsers');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($user);

        $em->flush();

        return $this->redirectToRoute('adminUsers');
    }
}
