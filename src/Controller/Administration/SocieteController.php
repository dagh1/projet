<?php

namespace App\Controller\Administration;

use App\Entity\Societe;
use App\Form\SocieteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SocieteController extends AbstractController
{
    /**
     * @Route("/societe", name="admin_societe_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $societes = $em->getRepository(Societe::class)->findAll();

        return $this->render('administration/societe/liste.html.twig', array(
            'societes' => $societes
        ));
    }

    /**
     * @Route("/societe/ajouter", name="admin_societe_ajouter")
     */
    public function ajout(Request $request)
    {
        $societe = new Societe();

        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($societe);
            $em->flush();

            return $this->redirectToRoute('admin_societe_liste');
        }

        return $this->render('administration/societe/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/societe/modifier/{id}", name="admin_societe_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $societe = $em->getRepository(Societe::class)->find($id);

        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_societe_liste');
        }

        return $this->render('administration/societe/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/societe/supprimer/{id}", name="admin_societe_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $societe = $em->getRepository(Societe::class)->find($id);

        if($societe)
        {
            $em->remove($societe);
            $em->flush();
        }

        return $this->redirectToRoute('admin_societe_liste');

    }


}
