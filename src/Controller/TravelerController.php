<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TravelerController
 * @package App\Controller
 * @Route("/traveler", name="app_traveler_")
 */
class TravelerController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function travelerIndexAction()
    {
        return $this->render('traveler/index.html.twig', [
            'controller_name' => 'TravelerController',
        ]);
    }
}
