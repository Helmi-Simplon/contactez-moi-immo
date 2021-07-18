<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Form\OffresType;
use App\Repository\OffresRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/vendeurs/add", name="offre_add")
     */
    public function addOffres(Request $request): Response
    {
        $offres = new Offres();
        $form = $this->createForm(OffresType::class, $offres);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $offres->setVendeur($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($offres);
            $em->flush();
            return $this->redirectToRoute('offres');
        }

        return $this->render('offres/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
