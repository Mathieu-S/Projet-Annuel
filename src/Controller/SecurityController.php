<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction(AuthenticationUtils $helper)
    {
        return $this->render('security/login.html.twig', [
            'lastUsername' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/register", name="security_register")
     */
    public function registerAction()
    {
        return $this->render('security/register-selector.html.twig');
    }

    /**
     * @Route("/register-user", name="security_register_user")
     */
    public function registerUserAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $roles[] = 'ROLE_USER';
        $user->setRoles($roles);

        $form = $this->createForm('App\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $request->getSession()->set('_security_main', serialize($token));

            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/register.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/register-hotel", name="security_register_hotel")
     */
    public function registerHotelAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $roles[] = 'ROLE_HOTEL';
        $user->setRoles($roles);

        $form = $this->createForm('App\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $request->getSession()->set('_security_main', serialize($token));

            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/register.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     * @throws \Exception
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
}
