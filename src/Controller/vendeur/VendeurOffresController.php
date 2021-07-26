<?php

namespace App\Controller\vendeur;

use App\Entity\Offres;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VendeurOffresController extends AbstractController
{
    /**
     * @Route("/vendeur/offres/{vendeur}", name="vendeur_offres", methods={"GET"}, requirements={"vendeur"="\d+"})
     */
    public function index(Offres $offres): Response
    {
        return $this->render('vendeurBO/vendeur_offres/index.html.twig', [
            'controller_name' => 'VendeurOffresController',
            'offres' => $offres,
        ]);
    }


}
