<?php

namespace App\Controller\acheteur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcheteurController extends AbstractController
{
    /**
     * @Route("/acheteur", name="acheteur")
     */
    public function index(): Response
    {
        return $this->render('acheteur/index.html.twig', [
            'controller_name' => 'AcheteurController',
        ]);
    }
}
