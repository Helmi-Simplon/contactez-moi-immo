<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Contact;
use App\Form\ContactReponseType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Repository\OffresRepository;
use App\Repository\ContactRepository;
use App\Repository\DemandesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepository, DemandesRepository $demandesRepository, OffresRepository $offresRepository): Response
    {
        $countUser = $userRepository->countUser();
        $countDemandes = $demandesRepository->countDemandes();
        $countOffres = $offresRepository->countOffres();
        return $this->render('adminBO/admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'countUser' => $countUser,
            'countDemandes' =>$countDemandes,
            'countOffres' =>$countOffres,
        ]);
    }

    /**
     * @Route("/admin/gestion-utilisateurs", name="admin_gestion_utilisateurs")
     */
    public function gestionUtilisateur(UserRepository $userRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $users = $userRepository->findAll();
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('adminBO/admin/utilisateurs.html.twig', [
            'pagination' => $pagination,
            'users' => $users,
        ]);
    }
     /**
     * @Route("/admin/gestion-utilisateurs/modification/{id}", name="admin_utilisateur_modification", requirements={"id"="\d+"})
     */
    public function modifUtilisateur(User $user,Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'L\'utilisateur a été modifié avec succès !');
        return $this->redirectToRoute('admin_gestion_utilisateurs');
        }
        return $this->render('adminBO/admin/maj.html.twig', [
        'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/gestion-utilisateurs/activation/{id}", name="admin_utilisateur_activation", requirements={"id"="\d+"})
     */
    public function activationUtilisateur(User $user): Response
    {
        //dd($user);
        $user->setActif( ($user->getActif()) ? false : true );
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('admin_gestion_utilisateurs');
    }
    /**
     * @Route("/admin/gestion-utilisateurs/suppression/{id}", name="admin_utilisateur_suppression", requirements={"id"="\d+"})
     */
    public function SupprimerUtlisateur(User $user): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès !');
        return $this->redirectToRoute('admin_gestion_utilisateurs');
    }

    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function adminContact(ContactRepository $contactRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $contacts = $contactRepository->findAll();
        $pagination = $paginator->paginate(
            $contacts,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('adminBO/contact/contact.html.twig', [
            'contacts' => $contacts,
            'pagination' => $pagination
        ]);
    }


    /**
     * @Route("/admin/contact/reponse/{id}",name="admin_contact_reponse", requirements={"id"="\d+"})
     */
    public function reponseContact(Contact $contact, MailerInterface $mailer, Request $request): Response
    {

        $form = $this->createForm(ContactReponseType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success','Message envoyé à ' . $contact->getExpediteur());
            //dd($contact);
            $email = (new TemplatedEmail())
                ->from(new Address('c.helmi@orange.fr', 'contactez-moi-immo.com'))
                ->to($contact->getExpediteur())
                ->subject('Contactez-moi-immo.com')
                ->htmlTemplate('adminBO/contact/recap.html.twig')
                ->context([
                    "contact" => $contact,

                ]);

            $mailer->send($email);

            return $this->redirectToRoute('admin_contact');
        }
        return $this->render('adminBO/contact/contactForm.html.twig', [
            'contact' => $contact,
            'form' => $form->createView()
        ]);
    }

}
