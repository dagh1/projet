<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\OffreStage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        return $this->render('administration/offrestage/liste.html.twig', array(
            'offrestages' => $offrestages
        ));
    }

}
