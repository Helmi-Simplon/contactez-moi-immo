<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandesController extends AbstractController
{
    /**
     * @Route("/demandes", name="demandes")
     */
    public function index(): Response
    {
        return $this->render('demandes/index.html.twig', [
            'controller_name' => 'Demandes',
        ]);
    }
}