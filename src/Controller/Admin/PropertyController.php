<?php

namespace App\Controller\Admin;

use App\Entity\Property;

use App\Form\PropertyFormType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    /**
     * @Route("/property/add", name="property_add")
     */
    public function addProperty(Request $request): Response
    {
        $property = new Property();

        $form = $this->createForm(PropertyFormType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Initialisation des valeurs par défaut
            // Le User connecté
            // Active à false
            $property->setUsers($this->getUser());
            //dd($this->getUser());
            $property->setActive(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/property/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property", name="admin_property_index")
     */
    public function indexProperty(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/property/index.html.twig', [
            'propertys' => $propertyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/property/activate/{id}", name="admin_property_activate", requirements={"id"="\d+"})
     */
    public function activateProperty(Property $property): Response
    {

        $property->setActive(($property->getActive()) ? false : true);

        /*
        if ($property->getActive() == true) {
            $property->setActive(false);
        } else {
            $property->setActive(true);
        }
        */

        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();
        //dd($em);
        return new Response("true");
    }

    /**
     * @Route("/admin/property/delete/{id}", name="admin_property_delete", requirements={"id"="\d+"})
     */
    public function deleteProperty(Property $property): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($property);
        $em->flush();
        $this->addFlash('success', 'Votre article a été supprimé avec succès !');
        return $this->redirectToRoute('admin_property_index');
    }

    /**
     * @Route("/admin/property/update/{id}", name="admin_property_update", requirements={"id"="\d+"})
     */
    public function updateProperty(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyFormType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();
            $this->addFlash('success', 'Votre article a été modifié avec succès !');
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/property/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
