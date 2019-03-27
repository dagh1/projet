<?php

namespace App\Controller\Administration;

use App\Entity\Universite;
use App\Form\UniversiteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UniversiteController extends AbstractController
{
    /**
     * @Route("/Universite", name="admin_Universite_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $Universites = $em->getRepository(Universite::class)->findAll();

        return $this->render('administration/Universite/liste.html.twig', array(
            'Universites' => $Universites
        ));
    }

    /**
     * @Route("/Universite/ajouter", name="admin_universite_ajouter")
     */
    public function ajout(Request $request)
    {
        $Universite = new Universite();

        $form = $this->createForm(UniversiteType::class, $Universite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Universite);
            $em->flush();

            return $this->redirectToRoute('admin_Universite_liste');
        }

        return $this->render('administration/Universite/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/Universite/modifier/{id}", name="admin_Universite_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Universite = $em->getRepository(Universite::class)->find($id);

        $form = $this->createForm(UniversiteType::class, $Universite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_Universite_liste');
        }

        return $this->render('administration/Universite/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/Universite/supprimer/{id}", name="admin_Universite_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Universite = $em->getRepository(Universite::class)->find($id);

        if($Universite)
        {
            $em->remove($Universite);
            $em->flush();
        }

        return $this->redirectToRoute('admin_Universite_liste');

    }


}



