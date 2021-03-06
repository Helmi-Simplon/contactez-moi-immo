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
     * @Route("/acheteurdemandes/{acheteur}", name="acheteurdemandes", methods={"GET"}, requirements={"acheteur"="\d+"})
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

     /**
     * @Route("/acheteurdemandes/tab/{acheteur}", name="acheteur_demandes_bo", methods={"GET"}, requirements={"acheteur"="\d+"})
     */
    public function ActionsDemande(Demandes $demandes): Response
    {
       // $demandes = $this->getDoctrine()->getRepository(Demandes::class)->findBy(['acheteur' => $id]);
       
        return $this->render('acheteurBO/acheteurdemandes/actions.html.twig', [
            'controller_name' => 'AcheteurdemandesController',
            'demandes' => $demandes,
           
        ]);
    }

     /**
     * @Route("/acheteurdemandes/editer/{id}", name="acheteur_demandes_maj", requirements={"id"="\d+"})
     */
    public function MajDemande(Demandes $demandes, Request $request): Response
    {
       // $demandes = $this->getDoctrine()->getRepository(Demandes::class)->findBy(['acheteur' => $id]);
       $form = $this->createForm(DemandesType::class, $demandes);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($demandes);
            $em->flush();
            $this->addFlash('success', 'Votre demande a ??t?? modifi??e avec succ??s !');
            return $this->redirectToRoute('acheteur_demandes_bo',[
                'acheteur' => $this->getUser()->getId(),
            ]);
        }
        return $this->render('acheteurBO/acheteurdemandes/maj_demande.html.twig', [
            'form' => $form->createView(),
            'demandes'=>$demandes,
           
        ]);
    }
    
    /**
     * @Route("/acheteurdemandes/activation/{id}", name="acheteur_demandes_activation", requirements={"id"="\d+"})
     */
    public function activerDemande(Demandes $demandes,Request $request): Response
    {
        //dd($demandes);
        $demandes->setActif( ($demandes->getActif()) ? false : true );

        $em = $this->getDoctrine()->getManager();
        $em->persist($demandes);
        $em->flush();
        if($demandes->getActif() === false){
            $this->addFlash('success', 'Votre demande a ??t?? d??sactiv??e avec succ??s !');
            }else{
            $this->addFlash('success', 'Votre demande a ??t?? activ??e avec succ??s !');
            }
            return $this->redirectToRoute('acheteur_demandes_bo',[
                'acheteur' => $this->getUser()->getId(),
            ]);
    }

    /**
     * @Route("/acheteurdemandes/delete/{id}", name="acheteur_demandes_suppression", requirements={"id"="\d+"})
     */
    public function supprimerDemande(Demandes $demandes): Response
    {
        //dd($demandes);
        $em = $this->getDoctrine()->getManager();
        $em->remove($demandes);
        $em->flush();
        $this->addFlash('success', 'Votre demande a ??t?? supprim?? avec succ??s !');
        return $this->redirectToRoute('acheteur_demandes_bo',[
            'acheteur' => $this->getUser()->getId(),
        ]);
    }

}
