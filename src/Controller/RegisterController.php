<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegisterController extends AbstractController
{

    private $guardAuthenticatorHandler;
    private $loginFormAuthenticator;
//    private $passwordEncoder;

    /**
     * RegisterController constructor.
     * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
     */
    public function __construct(GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator)
    {
        $this->guardAuthenticatorHandler = $guardAuthenticatorHandler;
        $this->loginFormAuthenticator = $loginFormAuthenticator;
//        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = new User();
        $registerForm = $this->createForm(RegisterType::class, $user, [
            'action' => $this->generateUrl('app_register'),
            'method' => 'POST'
        ]);

        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $user = $registerForm->getData();

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $registerForm->get('password')->getData()
                )
            );

            $user->setRoles(['IS_AUTHENTICATED_FULLY']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->loginFormAuthenticator,
                'main'
            );
        }






        return $this->render('register/index.html.twig', [
            'registerForm' => $registerForm->createView()
        ]);
    }




}
