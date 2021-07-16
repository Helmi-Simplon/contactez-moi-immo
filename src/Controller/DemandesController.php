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
        //On crée un objet $demande à partir de la classe Demandes(App\Entity\Demandes)
        $demande = new Demandes();
        //On crée un formulaire en utilisant la méthode createForm() avec les paramètres suivants : La classe DemandesType
        // et l'objet $demande
        $form = $this->createForm(DemandesType::class, $demande);
        //On appelle la methode handleRequest() qui prend $request comme paramètre, il vérifie les données envoyées 
        //quand le formulaire est validé
        $form->handleRequest($request);
        //si le formulaire est validé et les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            //On parmètre le champs user avec le user fournit dans le formulaire
            $demande->setAcheteur($this->getUser());
            //on appelle la methode getManager à partir de l'entité manager pour manager les requetes à utiliser
            $em = $this->getDoctrine()->getManager();
            //on fait un persist pour entrer le resultat de la requête utiliser dans la base
            $em->persist($demande);
            //on committe avec un flush
            $em->flush();
            //on se redirige vers la page d'accueil après la fin de l'opération
            return $this->redirectToRoute('demandes');
        }

        return $this->render('demandes/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }








}
