<?php

namespace App\Controller\guest;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Repository\PropertyRepository;
use App\Notification\ContactNotification;
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

    public function findallbien(Request $request, PaginatorInterface  $paginator): Response
    {
        $datanew = $this->getDoctrine()->getRepository(Property::class)->findBy([], ['createdAt' => 'desc']);

        $propertys = $paginator->paginate(
            $datanew,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('annonce/index.html.twig', [
            'property' => $propertys
        ]);
    }

    /**
     *---- @Route("/{id}", name="property_show_guest", methods={"GET","POST"})
     * @Route("/{slug}", name="property_show_guest", methods={"GET","POST"})
     */
    public function showguest(Property $bien, Request $request, ContactNotification $notification): Response
    {

        $contact = new Contact();
        $contact->setProperty($bien);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notification->notify($contact);

            $this->addFlash('success', 'Votre email a bien été envoyé à l\'annonceur');
            return $this->redirectToRoute('property_show_guest', [
                'id'   => $bien->getId()

            ]);
        }

        return $this->render('annonce/show.html.twig', [
            'bien' => $bien,
            'form' => $form->createView()
        ]);
    }
}
