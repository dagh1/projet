<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Rapport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        return $this->render('administration/rapport/liste.html.twig', array(
            'rapports' => $rapports
        ));
    }

}