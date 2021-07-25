<?php

namespace App\Controller\acheteur;

use App\Entity\Demandes;
use App\Form\DemandesType;
use Symfony\Component\HttpFoundation\Request;
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

     /**
     * @Route("/acheteurdemandes/add", name="acheteurdemandes_add")
     */
    public function ajoutDemande(Request $request): Response
    {
        $demande = new Demandes();
        $form = $this->createForm(DemandesType::class, $demande);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $demande->setAcheteur($this->getUser());
            $demande->setActif(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute('demandes');
        }

        return $this->render('acheteurBO/acheteurdemandes/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
