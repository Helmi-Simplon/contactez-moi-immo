<?php

namespace App\Controller;

use App\Entity\Demandes;
use App\Form\DemandesType;
use App\Repository\DemandesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandesController extends AbstractController
{
    /**
     * @Route("/demandes", name="demandes")
     */
    public function index(DemandesRepository $demandesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $demandes = $demandesRepository->findAllWithAdresses();
        //dd($demandes);
        $pagination = $paginator->paginate(
            $demandes,
            $request->query->getInt('page', 1),
            8
        );
   

        return $this->render('demandes/index.html.twig', [
            'demandes' => $demandes,
            'pagination' => $pagination,
        ]);
    }


/**
 * @Route("/vendeurs/demande/{slug}", name="demande_detail", methods={"GET"})
 */
public function detailDemande(Demandes $demande): Response
    {
        //dd($demande);
    return $this->render('demandes/demande_detail.html.twig', [
        'demande' => $demande,
    ]);
    }







/**
     * @Route("/acheteurs/add", name="demande_add")
     */
    public function addDemande(Request $request): Response
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

        return $this->render('demandes/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }








}
