<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VilleController extends AbstractController
{
    /**
     * @Route("admin/ville", name="admin_ville")
     */
    public function index(AdresseRepository $adresse): Response
    {
        $adresses = $adresse->findAll();
        return $this->render('adminBO/ville/index.html.twig', [
            'controller_name' => 'VilleController',
            'adresses' => $adresses,
        ]);
    }
     /**
     * @Route("/admin/ville/ajouter", name="admin_ville_ajouter")
     */
    public function AjouterVille(Request $request): Response
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();
            $this->addFlash('success', 'La ville a été ajoutée avec succès !');
            return $this->redirectToRoute('admin_ville');
        }

        return $this->render('adminBO/ville/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/ville/modifier/{id}", name="admin_ville_modifier", requirements={"id"="\d+"})
     */
    public function ModifierTypeBien(Adresse $adresse, Request $request): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();
            $this->addFlash('success', 'Modification OK !');
            return $this->redirectToRoute('admin_ville');
        }

        return $this->render('adminBO/ville/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/ville/suppression/{id}", name="admin_ville_suppression", requirements={"id"="\d+"})
     */
    public function SupprimerUtlisateur(Adresse $adresse): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($adresse);
        $em->flush();
        $this->addFlash('success', 'Suppression OK');
        return $this->redirectToRoute('admin_ville');
    }
}
