<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


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




}
