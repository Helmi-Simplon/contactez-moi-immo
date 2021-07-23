<?php

namespace App\Controller\acheteur;

use App\Entity\Demandes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AcheteurdemandesController extends AbstractController
{
    /**
     * @Route("/acheteurdemandes/{id}", name="acheteurdemandes", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function index(Demandes $demandes): Response
    {
        return $this->render('acheteurBO/acheteurdemandes/index.html.twig', [
            'controller_name' => 'AcheteurdemandesController',
            'demandes' => $demandes,
           
        ]);
    }
}
