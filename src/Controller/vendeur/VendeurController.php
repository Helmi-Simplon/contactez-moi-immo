<?php

namespace App\Controller\vendeur;

use App\Entity\User;
use App\Form\MajProfilType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VendeurController extends AbstractController
{
    /**
     * @Route("/vendeur", name="vendeur")
     */
    public function index(): Response
    {
        return $this->render('vendeurBO/vendeur/index.html.twig', [
            'controller_name' => 'VendeurController',
        ]);
    }

     /**
     * @Route("/vendeur/profil/update/{id}", name="vendeur_profil_update", requirements={"id"="\d+"})
     */
    public function updateVendeur(User $user, Request $request): Response
    {
        $form = $this->createForm(MajProfilType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre profil a été modifié avec succès !');
            return $this->redirectToRoute('vendeur');
        }
        
        return $this->render('vendeurBO/vendeur/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/vendeur/profil/desactivation", name="vendeur_desactivation")
     */
    public function desctivationPage(): Response
    {
        return $this->render('vendeurBO/vendeur/desactivation.html.twig', [
            'controller_name' => 'VendeurController',
        ]);
    }


     /**
     * @Route("/vendeur/profil/desactivation/{id}", name="vendeur_profil_desactivate", requirements={"id"="\d+"})
     */
    public function DesactivateVendeur(User $user, Request $request): Response
    {
        $user->setActif( ($user->getActif()) ? false : true );

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('vendeur');
        
   
    }
}
