<?php

namespace App\Controller\guest;

use App\Entity\Property;
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



    /**
     * @Route("/{id}/", name="property_show_guest", methods={"GET"})
     */
    public function showguest(Property $bien): Response
    {
        return $this->render('annonce/show.html.twig', [
            'bien' => $bien,
        ]);
    }
}
