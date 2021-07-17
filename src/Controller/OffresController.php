<?php

namespace App\Controller;

use App\Repository\OffresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffresController extends AbstractController
{
    /**
     * @Route("/offres", name="offres")
     */
    public function index(OffresRepository $offresRepository): Response
    {
        $offres = $offresRepository -> findAllWithAdressesAndImages();
        dd($offres);
        return $this->render('offres/index.html.twig', [
            'controller_name' => 'OffresController',
            'offres' => $offres,
        ]);
    }

    
}
