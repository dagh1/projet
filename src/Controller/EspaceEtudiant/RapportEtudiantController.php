<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Etudiant;

use App\Entity\RapportEtudiant;

use App\Form\RapportEtudiantType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RapportEtudiantController extends AbstractController
{
    /**
     * @Route("/rapport_etudiant/gestion", name="espace_etudiant_rapport_et_gestion")
     */
    public function liste(Request $request)
    {


        $em = $this->getDoctrine()->getManager();

        $rapports = $em->getRepository(RapportEtudiant::class)->findAll();

        return $this->render('espace_etudiant/rapport_etudiant/gestion.html.twig', array(
            'rapports' => $rapports
        ));
    }


    /**
     * @Route("/rapport_etudiant/gestion/creer", name="espace_etudiant_rapport_et_creer")
     */

    public function ajout(Request $request)
    {
        $rapportEtudiant = new RapportEtudiant();

        $form = $this->createForm(RapportEtudiantType::class, $rapportEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $etudiant = $em->getRepository(Etudiant::class)->findOneBy(array('utilisateur' => $user));
            $rapportEtudiant->setEtudiant($etudiant);
            $em->persist($rapportEtudiant);
            $em->flush();

            return $this->redirectToRoute('espace_etudiant_rapport_et_gestion');
        }

        return $this->render('espace_etudiant/rapport_etudiant/creation.html.twig', array(
            'form' => $form->createView()
        ));

    }
}