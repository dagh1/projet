<?php

namespace App\Controller\Administration;

use App\Entity\Rapport;
use App\Form\RapportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RapportController extends AbstractController
{
    /**
     * @Route("/rapport", name="admin_rapport_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $rapports = $em->getRepository(Rapport::class)->findAll();

        return $this->render('administration/rapport/liste.html.twig', array(
            'rapports' => $rapports
        ));
    }

    /**
     * @Route("/rapport/ajouter", name="admin_rapport_ajouter")
     */
    public function ajout(Request $request)
    {
        $rapport = new Rapport();

        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rapport);
            $em->flush();

            return $this->redirectToRoute('admin_rapport_liste');
        }

        return $this->render('administration/rapport/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/rapport/modifier/{id}", name="admin_rapport_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rapport = $em->getRepository(Rapport::class)->find($id);

        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_rapport_liste');
        }

        return $this->render('administration/rapport/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/rapport/supprimer/{id}", name="admin_rapport_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rapport = $em->getRepository(Rapport::class)->find($id);

        if($rapport)
        {
            $em->remove($rapport);
            $em->flush();
        }

        return $this->redirectToRoute('admin_rapport_liste');

    }


}