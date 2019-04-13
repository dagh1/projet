<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Etudiant;
use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Profil extends AbstractController
{
    /**
     * @Route("/", name="espace_etudiant_index")
     */
    public function index()
    {
        return $this->render('espace_etudiant/accueil.html.twig');
    }

    /**
     * @Route("/profil", name="espace_etudiant_profil")
     */

    public function profil()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $etudiant = $em->getRepository(Etudiant::class)->findOneBy(array('utilisateur' => $user));


        return $this->render('espace_etudiant/profil/profils.html.twig', array(
            'etudiant' => $etudiant
        ));
    }

    /**
     * @Route("/compte", name="espace_etudiant_compte")
     */

    public function compte()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $etudiant = $em->getRepository(Etudiant::class)->findOneBy(array('utilisateur' => $user));


        return $this->render('espace_etudiant/profil/compte.html.twig', array(
            'etudiant' => $etudiant
        ));
    }
}
