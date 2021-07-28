<?php

namespace App\Controller\Admin;

use App\Repository\TypeBienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
