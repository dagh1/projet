<?php

namespace App\Controller\Administration;

use App\Entity\OffreStage;
use App\Form\OffreStageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OffreStageController extends AbstractController
{
    /**
     * @Route("/offrestage", name="admin_offrestage_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $offrestages = $em->getRepository(OffreStage::class)->findAll();

        return $this->render('administration/offrestage/liste.html.twig', array(
            'offrestages' => $offrestages
        ));
    }

    /**
     * @Route("/offrestage/ajouter", name="admin_offrestage_ajouter")
     */
    public function ajout(Request $request)
    {
        $offrestage = new OffreStage();

        $form = $this->createForm(OffreStageType::class, $offrestage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offrestage);
            $em->flush();

            return $this->redirectToRoute('admin_offrestage_liste');
        }

        return $this->render('administration/offrestage/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/offrestage/modifier/{id}", name="admin_offrestage_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $offrestage = $em->getRepository(OffreStage::class)->find($id);

        $form = $this->createForm(OffreStageType::class, $offrestage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_offrestage_liste');
        }

        return $this->render('administration/offrestage/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/offrestage/supprimer/{id}", name="admin_offrestage_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $offrestage = $em->getRepository(OffreStage::class)->find($id);

        if($offrestage)
        {
            $em->remove($offrestage);
            $em->flush();
        }

        return $this->redirectToRoute('admin_offrestage_liste');

    }


}
