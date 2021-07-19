<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyHomeController extends AbstractController
{
    /**
     * @Route("/", name="home_annonce")
     */

    public function findallbien(PropertyRepository $bienRepository): Response
    {

        $property = $bienRepository->findall();
        return $this->render('annonce/index.html.twig', [
            'property' => $property,
        ]);
    }
}
