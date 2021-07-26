<?php

namespace App\Controller\vendeur;

use App\Entity\Offres;
use App\Form\OffresType;
use Symfony\Component\HttpFoundation\Request;
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
            'offres' => $offres,
        ]);
    }

    /**
     * @Route("/vendeur/offres/add", name="vendeur_offres_add")
     */
    public function ajoutOffre(Request $request): Response
    {
        $offres = new Offres();
        $form = $this->createForm(OffresType::class, $offres);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $offres->setVendeur($this->getUser());
            $offres->setActif(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($offres);
            $em->flush();
            return $this->redirectToRoute('vendeur');
        }

        return $this->render('vendeurBO/vendeur_offres/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/vendeur/offres/actions/{vendeur}", name="vendeur_offres_actions", methods={"GET"}, requirements={"vendeur"="\d+"})
     */
    public function ActionsOffre(Offres $offres): Response
    {
       // $offres = $this->getDoctrine()->getRepository(Offres::class)->findBy(['vendeur' => $id]);
       
        return $this->render('vendeurBO/vendeur_offres/actions.html.twig', [
            'offres' => $offres,
           
        ]);
    }

     /**
     * @Route("/vendeur/offres/editer/{id}", name="vendeur_offres_maj", requirements={"id"="\d+"})
     */
    public function MajOffre(Offres $offres, Request $request): Response
    {
       $form = $this->createForm(OffresType::class, $offres);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offres);
            $em->flush();
            $this->addFlash('success', 'Votre offre a été modifiée avec succès !');
            return $this->redirectToRoute('offres');
        }
        return $this->render('vendeurBO/vendeur_offres/maj_offre.html.twig', [
            'form' => $form->createView(),
           
        ]);
    }
}
