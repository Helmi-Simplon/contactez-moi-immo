<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\OffresRepository;
use App\Repository\DemandesRepository;
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
    public function gestionUtilisateur(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('adminBO/admin/utilisateurs.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }
}
