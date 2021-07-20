<?php

namespace App\Controller;

use App\Entity\Images;
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
        //dd($offres);
        return $this->render('offres/index.html.twig', [
            'controller_name' => 'OffresController',
            'offres' => $offres,
        ]);
    }

    /**
 * @Route("/acheteurs/offre/{slug}", name="offre_detail", methods={"GET"})
 */
public function detailOffre(Offres $offres): Response
{

    //dd($offres);
return $this->render('offres/offre_detail.html.twig', [
    'controller_name' => 'TestController',
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
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {

            $offres->setVendeur($this->getUser());
            $images = $form->get('image')->getData();
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
            return $this->redirectToRoute('offres');
        }

        return $this->render('offres/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
