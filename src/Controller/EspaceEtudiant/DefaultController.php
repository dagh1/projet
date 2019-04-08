<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Etudiant;
use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="espace_etudiant_index")
     */
    public function index()
    {
        return $this->render('espace_etudiant/accueil.html.twig');
    }


    public function nav()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $etudiant = $em->getRepository(Etudiant::class)->findOneBy(array('utilisateur' => $user));
        $projets = $em->getRepository(Projet::class)->findBy(array('etudiant'=>$etudiant), array('id'=>'desc'));

        return $this->render('espace_etudiant/includes/nav.html.twig', array(
            'projest'=> $projets
        ));
    }
}
