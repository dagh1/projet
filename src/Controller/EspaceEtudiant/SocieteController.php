<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Societe;
use App\Form\SocieteChercherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SocieteController extends AbstractController
{
    /**
     * @Route("/societe", name="espace_etudiant_societe_liste")
     */
    public function liste(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $societes = $em->getRepository(Societe::class)->findAll();

        return $this->render('espace_etudiant/societe/liste.html.twig', array(
            'societes' => $societes,
        ));
    }

    /**
     * @Route("/societe/chercher", name="espace_etudiant_societe_chercher")
     */
    public function chercher(Request $request)
    {
        $donnees = $request->query->all(); // récuperer tous les paramaetres dans l'url

        $em = $this->getDoctrine()->getManager();
        $societes = $em->getRepository(Societe::class)->chercher($donnees);

        return $this->render('espace_etudiant/societe/liste.html.twig', array(
            'societes' => $societes,
        ));
    }

}
