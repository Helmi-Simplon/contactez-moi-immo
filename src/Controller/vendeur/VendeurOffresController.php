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
            'controller_name' => 'VendeurOffresController',
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
}
