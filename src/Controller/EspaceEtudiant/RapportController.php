<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Rapport;
use App\Form\RapportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RapportController extends AbstractController
{
    /**
     * @Route("/rapport", name="espace_etudiant_rapport_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $rapports = $em->getRepository(Rapport::class)->findAll();

        return $this->render('espace_etudiant/rapport/liste.html.twig', array(
            'rapports' => $rapports
        ));
    }
    /**
     * @Route("/rapport/chercher", name="espace_etudiant_rapport_chercher")
     */
    public function chercher(Request $request)
    {
        $donnees = $request->query->all();

        $em = $this->getDoctrine()->getManager();
        $Rapport = $em->getRepository(Rapport ::class)->chercher($donnees);

        return $this->render('espace_etudiant/rapport/liste.html.twig', array(
            'rapports' => $Rapport,
        ));
    }





}