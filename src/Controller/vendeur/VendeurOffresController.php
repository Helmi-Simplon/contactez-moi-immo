<?php

namespace App\Controller\vendeur;

use App\Entity\Images;
use App\Entity\Offres;
use App\Form\ImagesType;
use App\Form\OffresType;
use Doctrine\Common\Collections\Collection;
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
            // On récupère les images transmises
            $images = $form->get('image')->getData();
    
            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
        
                // On copie le fichier dans le dossier uploads
                $image->move(
                $this->getParameter('images_directory'),
                $fichier
                );
        
                // On crée l'image dans la base de données
                $image = new Images();
                $image->setUrlImage($fichier);
                $offres->addImage($image);
            }
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
            // On récupère les images transmises
            $images = $form->get('image')->getData();
    
            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
        
                // On copie le fichier dans le dossier uploads
                $image->move(
                $this->getParameter('images_directory'),
                $fichier
                );
        
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setUrlImage($fichier);
                $offres->addImage($img);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($offres);
            $em->flush();
            $this->addFlash('success', 'Votre offre a été modifiée avec succès !');
            //$referer = $request->headers->get('referer');
            // dd($this->getUser()->getId());
            return $this->redirectToRoute('vendeur_offres_actions',[
                'vendeur' => $this->getUser()->getId(),
            ]);
        }
        return $this->render('vendeurBO/vendeur_offres/maj_offre.html.twig', [
            'form' => $form->createView(),
            'offres' => $offres,
           
        ]);
    }

    /**
     * @Route("/vendeur/offres/activation/{id}", name="vendeur_offres_activation", requirements={"id"="\d+"})
     */
    public function activerOffre(Offres $offres, Request $request): Response
    {
        //dd($offres);
        $offres->setActif( ($offres->getActif()) ? false : true );

        $em = $this->getDoctrine()->getManager();
        $em->persist($offres);
        $em->flush();
        if($offres->getActif() === false){
        $this->addFlash('success', 'Votre offre a été désactivée avec succès !');
        }else{
        $this->addFlash('success', 'Votre offre a été activée avec succès !');
        }
        return $this->redirectToRoute('vendeur_offres_actions',[
            'vendeur' => $this->getUser()->getId(),
        ]);
       
    }

     /**
     * @Route("/vendeur/offres/suppression/{id}", name="vendeur_offres_suppression", requirements={"id"="\d+"})
     */
    public function supprimerOffre(Offres $offres,Request $request): Response
    {   
        foreach($offres->getImage() as $image){
            $offres->removeImage($image);
        }
        
        //dd($offres);
        $em = $this->getDoctrine()->getManager();
        $em->remove($offres);
        $em->flush();
        $this->addFlash('success', 'Votre offre a été supprimé avec succès !');
        return $this->redirectToRoute('vendeur_offres_actions',[
            'vendeur' => $this->getUser()->getId(),
        ]);
    }

    /**
     * @Route("/vendeur/offres/image/{id}", name="vendeur_offres_edit_image", requirements={"id"="\d+"})
     */
    public function imageOffre(Images $images, Request $request): Response
    {
        //dd($offres);
        $form = $this->createForm(ImagesType::class, $images);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $imgs = $form->get('url_image')->getData();
    
            // On boucle sur les images
            foreach($imgs as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
        
                // On copie le fichier dans le dossier uploads
                $image->move(
                $this->getParameter('images_directory'),
                $fichier
                );
        
                // On crée l'image dans la base de données
                $images->setUrlImage($fichier);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($images);
            $em->flush();
        
            $this->addFlash('success', 'Votre image a été mise à jour avec succès !');
        }

        
        return $this->render('vendeurBO/vendeur_offres/edit_image.html.twig',[
            'form' =>$form->createView(),
            'images' =>$images,
        ]);
       
    }

    /**
     * @Route("/vendeur/offres/images/{offre}", name="vendeur_offres_image", requirements={"offre"="\d+"})
     */
    public function editImageOffre(Images $images, Request $request): Response
    {
        return $this->render('vendeurBO/vendeur_offres/maj_images.html.twig',[
            'images' =>$images,
        ]);
    }

}
