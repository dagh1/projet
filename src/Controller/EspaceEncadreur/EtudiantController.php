<?php

namespace App\Controller\EspaceEncadreur;

use App\Entity\Encadrement;
use App\Entity\Encadreur;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="espace_encadreur_etudiant_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $encadreur = $em->getRepository(Encadreur::class)->findOneBy(array('utilisateur' => $user));

        $etudiants = $em->getRepository(Etudiant::class)->findBy(array(
            'universite' => $encadreur->getUniversite(), 'domaine' => $encadreur->getDomaine()
        ));

        $encadrements = $em->getRepository(Encadrement::class)->findBy(array('encadreur' => $encadreur));

        $ids = array_map(function ($entity) {
            return $entity->getEtudiant()->getId();
        }, $encadrements);

        return $this->render('espace_encadreur/etudiant/liste.html.twig', array(
            'etudiants' => $etudiants,
            'universite'=> $encadreur->getUniversite(),
            'ids'=> $ids
        ));
    }

}
