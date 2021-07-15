<?php

namespace App\Controller;

use App\Repository\AdresseRepository;
use App\Repository\DemandesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandesController extends AbstractController
{
    /**
     * @Route("/demandes", name="demandes")
     */
    public function index(DemandesRepository $demandesRepository): Response
    {
        $demandes = $demandesRepository->findAllWithAdresses();
        //dd($demandes);
        
   

        return $this->render('demandes/index.html.twig', [
            'controller_name' => 'Demandes',
            'demandes' => $demandes,
            
        ]);
    }
}
