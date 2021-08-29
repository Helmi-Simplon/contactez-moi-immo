<?php

namespace App\Controller\acheteur;

use App\Entity\User;
use App\Entity\Images;
use App\Form\MajProfilType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AcheteurController extends AbstractController
{
    /**
     * @Route("/acheteur", name="acheteur")
     */
    public function index(): Response
    {
        return $this->render('acheteurBO/acheteur/index.html.twig', [
            'controller_name' => 'AcheteurController',
        ]);
    }

     /**
     * @Route("/acheteur/profil/update/{id}", name="acheteur_profil_update", requirements={"id"="\d+"})
     */
    public function updateAcheteur(User $user,Images $images, Request $request): Response
    {
        $form = $this->createForm(MajProfilType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $imgs = $form->get('image')->getData();
    
            // On boucle sur les images
            foreach($imgs as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
        
                // On copie le fichier dans le dossier uploads
                $image->move(
                $this->getParameter('image_directory'),
                $fichier
                );
        
                // On crée l'image dans la base de données
                $images->setUrlImage($fichier);
                $user->addImage($images);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre profil a été modifié avec succès !');
            return $this->redirectToRoute('acheteur');
        }
        
        return $this->render('acheteurBO/acheteur/update.html.twig', [
            'form' => $form->createView(),
            'user'=> $user,
        ]);
    }

    /**
     * @Route("/acheteur/profil/desactivate/{id}", name="acheteur_profil_desactivate", requirements={"id"="\d+"})
     */
    public function DesactivateAcheteur(User $user, Request $request): Response
    {
        $form = $this->createForm(MajProfilType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($user->getActif()){
            $user->setActif(false);
            }
            else{
            $user->setActif(true);   
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre profil a été désactivé avec succès !');
            return $this->redirectToRoute('acheteur');
        }
        
        return $this->render('acheteurBO/acheteur/desactivation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
