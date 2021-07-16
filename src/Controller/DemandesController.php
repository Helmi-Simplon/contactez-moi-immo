<?php

namespace App\Controller;

use App\Entity\Demandes;
use App\Form\DemandesType;
use App\Repository\UserRepository;
use App\Repository\AdresseRepository;
use App\Repository\DemandesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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


/**
     * @Route("/acheteurs/add", name="demande_add")
     */
    public function addDemande(Request $request): Response
    {
        $demande = new Demandes();
        $form = $this->createForm(DemandesType::class, $demande);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $demande->setAcheteur($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute('demandes');
        }

        return $this->render('demandes/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }








}
