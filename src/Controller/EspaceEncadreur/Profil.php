<?php

namespace App\Controller\EspaceEncadreur;

use App\Entity\Encadreur;
use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Profil extends AbstractController
{
    /**
     * @Route("/", name="espace_encadreur_index")
     */
    public function index()
    {
        return $this->render('espace_encadreur/accueil.html.twig');
    }

    /**
     * @Route("/profil", name="espace_encadreur_profil")
     */

    public function profil()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $encadreur = $em->getRepository(Encadreur::class)->findOneBy(array('utilisateur' => $user));


        return $this->render('espace_encadreur/profil/profils.html.twig', array(
            'encadreur' => $encadreur
        ));
    }

    /**
     * @Route("/compte", name="espace_encadreur_compte")
     */

    public function compte()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $encadreur = $em->getRepository(Encadreur::class)->findOneBy(array('utilisateur' => $user));


        return $this->render('espace_encadreur/profil/compte.html.twig', array(
            'encadreur' => $encadreur
        ));
    }
}
