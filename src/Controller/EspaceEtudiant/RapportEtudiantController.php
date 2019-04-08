<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Etudiant;

use App\Entity\Projet;
use App\Entity\RapportEtudiant;

use App\Form\RapportEtudiantType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RapportEtudiantController extends AbstractController
{
    /**
     * @Route("/rapport_projet/creer/{id}", name="espace_etudiant_rapport_projet_creer")
     */

    public function ajout(Request $request, Projet $projet)
    {
        $rapportEtudiant = new RapportEtudiant();

        $form = $this->createForm(RapportEtudiantType::class, $rapportEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $rapportEtudiant->setProjet($projet);
            $em->persist($rapportEtudiant);
            $em->flush();

            return $this->redirectToRoute('espace_etudiant_projet_voir', array('id'=> $projet->getId()));
        }

        return $this->render('espace_etudiant/rapport_etudiant/creation.html.twig', array(
            'form' => $form->createView()
        ));

    }
}