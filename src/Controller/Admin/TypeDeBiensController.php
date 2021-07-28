<?php

namespace App\Controller\Admin;

use App\Entity\TypeBien;
use App\Form\TypeBienType;
use App\Repository\TypeBienRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeDeBiensController extends AbstractController
{
    /**
     * @Route("admin/type-de-biens", name="admin_type_de_biens")
     */
    public function index(TypeBienRepository $typeBienRepository): Response
    {
        $types = $typeBienRepository->findAll();

        return $this->render('adminBO/type_de_biens/index.html.twig', [
            'controller_name' => 'TypeDeBiensController',
            'types'=>$types,
        ]);
    }

    /**
     * @Route("/admin/type-de-biens/ajouter", name="admin_type_de_biens_ajouter")
     */
    public function AjouterTypeBien(Request $request): Response
    {
        $type = new TypeBien();
        $form = $this->createForm(TypeBienType::class, $type);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            $this->addFlash('success', 'Un nouveau type de biens a été ajoutée avec succès !');
            return $this->redirectToRoute('admin_type_de_biens');
        }

        return $this->render('adminBO/type_de_biens/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/type-de-biens/modifier/{id}", name="admin_type_de_biens_modifier", requirements={"id"="\d+"})
     */
    public function ModifierTypeBien(TypeBien $typeBien, Request $request): Response
    {
        $form = $this->createForm(TypeBienType::class, $typeBien);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeBien);
            $em->flush();
            $this->addFlash('success', 'Modification OK !');
            return $this->redirectToRoute('admin_type_de_biens');
        }

        return $this->render('adminBO/type_de_biens/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/type-de-biens/suppression/{id}", name="admin_type_de_biens_suppression", requirements={"id"="\d+"})
     */
    public function SupprimerUtlisateur(TypeBien $typeBien): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($typeBien);
        $em->flush();
        $this->addFlash('success', 'Suppression OK');
        return $this->redirectToRoute('admin_type_de_biens');
    }
}
