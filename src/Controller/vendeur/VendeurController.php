<?php

namespace App\Controller\vendeur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendeurController extends AbstractController
{
    /**
     * @Route("/vendeur", name="vendeur")
     */
    public function index(): Response
    {
        return $this->render('vendeurBO/vendeur/index.html.twig', [
            'controller_name' => 'VendeurController',
        ]);
    }
}
