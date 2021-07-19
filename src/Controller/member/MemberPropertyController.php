<?php

namespace App\Controller\member;

use App\Entity\Property;
use App\Entity\Images;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/member")
 */
class MemberPropertyController extends AbstractController
{
    /**
     * @Route("/", name="property_index", methods={"GET"})
     */
    public function index(PropertyRepository $propertyRepository): Response
    {


        return $this->render('member/index.html.twig', [
            'property' => $propertyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="property_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $bien = new Property();
        //$myuser = new Users;
        $form = $this->createForm(PropertyType::class, $bien);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau name de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                // dd($image);

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son name)
                $img = new Images();
                $img->setName($fichier);
                $bien->addImage($img);

                // On recupere l'id de l'user connecter et on insere son id 
                // en base de donnée sur la table des property.
                $bien->setUsers($this->getUser());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bien);
            $entityManager->flush();

            return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/new.html.twig', [
            'bien' => $bien,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="property_show", methods={"GET"})
     */
    public function show(Property $bien): Response
    {
        return $this->render('member/show.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="property_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Property $bien): Response
    {
        $form = $this->createForm(PropertyType::class, $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau name de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son name)
                $img = new Images();
                $img->setName($fichier);
                $bien->addImage($img);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/edit.html.twig', [
            'bien' => $bien,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="property_delete", methods={"POST"})
     */
    public function delete(Request $request, Property $bien): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/image/{id}", name="property_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            // On récupère le name de l'image
            $name = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $name);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }


    // Requete de sql de selection des propertys by users

    /**
     * @Route("/view/{id}", methods={"GET"}, name="app_property_list")
     */
    public function listPropertysByUser($id): Response
    {
        // $userid = $this->getUser()->getId();
        // dd($userid);
        $propertys = $this->getDoctrine()->getRepository(Property::class)->findBy(['users' => $id]);
        // dd($propertys);
        return $this->render('member/_list.html.twig', [
            'propertys' => $propertys,
        ]);
    }
}
