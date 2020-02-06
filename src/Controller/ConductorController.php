<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConductorController extends AbstractController
{
    /**
     * @Route("/conductor", name="conductor")
     */
    public function index()
    {
        return $this->render('conductor/index.html.twig', [
            'controller_name' => 'ConductorController',
        ]);
    }
}
