<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\OffreStage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OffreStageController extends AbstractController
{
    /**
     * @Route("/offrestage", name="espace_etudiant_offrestage_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $offrestages = $em->getRepository(OffreStage::class)->findAll();

        return $this->render('espace_etudiant/offreStage/liste.html.twig', array(
            'offrestages' => $offrestages
        ));
    }



    /**
     * @Route("/offrestage/chercher", name="espace_etudiant_offreStage_chercher")
     */
    public function chercher(Request $request)
    {
        $donnees = $request->query->all();

        $em = $this->getDoctrine()->getManager();
        $offrestages = $em->getRepository(OffreStage::class)->chercher($donnees);

        return $this->render('espace_etudiant/offreStage/liste.html.twig', array(
            'offrestages' => $offrestages,
        ));
    }

    /**
     * @Route("/offrestage/{id}", name="espace_etudiant_offrestage_show")
     */

    public function show(OffreStage $offreStage )
    {

        return $this->render('espace_etudiant/offreStage/show.html.twig',[
            'offrestage'=>$offreStage
        ]);
    }





}

