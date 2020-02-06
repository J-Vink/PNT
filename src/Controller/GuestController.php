<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


///**
// * Class GuestController
// * @package App\Controller
// * @Route("/" name="guest_")
// */
class GuestController extends AbstractController
{
    private static $navlinks = [
        [
            'name' => 'Home',
            'path' => 'app_index'
        ],
        [
            'name' => 'About us',
            'path' => 'app_about_us'
        ],
        [
            'name' => 'Contact',
            'path' => 'app_contact'
        ]

    ];
    /**
     * @Route("/", name="app_index")
     */
    public function indexAction()
    {
        return $this->render('guest/index.html.twig', [
            'controller_name' => 'GuestController',
            'links' => self::$navlinks,
        ]);
    }

    /**
     * @Route("/about/us", name="app_about_us")
     */
    public function aboutUs()
    {
        return $this->render('guest/about-us.html.twig', [
            'controller_name' => 'GuestController',
            'links' => self::$navlinks,
        ]);
    }
    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact()
    {
        return $this->render('guest/contact.html.twig', [
            'controller_name' => 'GuestController',
            'links' => self::$navlinks,
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            if($this->getUser()->getRoles() == ["ROLE_TRAVELER"]){
                return $this->redirectToRoute('app_traveler_index');
            }
            if($this->getUser()->getRoles() == ["ROLE_CONDUCTOR"]){
                return $this->redirectToRoute('app_traveler_index');
            }
            if($this->getUser()->getRoles() == ["ROLE_ADMIN"]){
                return $this->redirectToRoute('app_traveler_index');
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setBalance(0);
            $user->setRoles(['ROLE_TRAVELER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
