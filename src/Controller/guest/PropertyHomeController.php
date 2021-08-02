<?php

namespace App\Controller\guest;


use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertyFormSearchType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PropertyHomeController extends AbstractController
{
    /**
     * @Route("/", name="home_annonce")
     */

    public function findallbien(Request $request, PaginatorInterface  $paginator, PropertyRepository $propertyrepository): Response
    {
        // Creation du formulaire de recherche
        $search = new PropertySearch();
        $form = $this->createForm(PropertyFormSearchType::class, $search);
        $form->handleRequest($request);


        $propertys = $paginator->paginate(
            //La requete cible
            $propertyrepository->findAllVisibleQuery($search),

            //numero de page
            $request->query->getInt('page', 1),

            //La limite d'enregistrement à renvoyer sur une page
            4
        );
        // dd($request);

        return $this->render('annonce/index.html.twig', [
            'property' => $propertys,

            // renovoie  du formulaire de recherche à la vue (annonce/index.html.twig)
            'form'         => $form->createView()
        ]);
    }

    /**
     * @Route("/{slug}", name="property_show_guest", methods={"GET","POST"})
     */
    public function showguest(Property $bien): Response
    {

        return $this->render('annonce/show.html.twig', [
            'bien' => $bien

        ]);
    }
}
