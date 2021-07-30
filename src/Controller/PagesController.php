<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'Accueil',
        ]);
    }
     /**
     * @Route("/contact", name="home_contact")
     */
    public function contact(Request $request): Response
    {
        $contact= new Contact();

        $form = $this->createForm(ContactType::class,$contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $contact->setDestinataire('admin@admin.com');
            $contact->setReponse('');
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success','Votre courriel a été envoyé, un retour sera envoyé à ' . $contact->getExpediteur());

            return $this->redirectToRoute('home_contact');
        }
        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
