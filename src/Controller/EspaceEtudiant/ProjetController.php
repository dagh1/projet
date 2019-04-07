<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Etudiant;
use App\Entity\Projet;
use App\Entity\Societe;
use App\Form\ProjetType;
use App\Form\SocieteChercherType;
use App\Repository\SocieteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    /**
     * @Route("/projet/gestion", name="espace_etudiant_projet_gestion")
     */
    public function liste(Request $request)
    {


            $em = $this->getDoctrine()->getManager();

        $projets = $em->getRepository(Projet::class)->findAll();

        return $this->render('espace_etudiant/projet/gestion.html.twig', array(
            'projets' => $projets
        ));
}




    /**
     * @Route("/projet/gestion/creer", name="espace_etudiant_projet_creer")
     */


    public function ajout(Request $request)
    {
        $projets = new Projet();

        $form = $this->createForm(ProjetType::class, $projets);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $etudiant = $em->getRepository(Etudiant::class)->findOneBy(array('utilisateur' => $user));
            $projets->setEtudiant($etudiant);
            $em->persist($projets);
            $em->flush();

            return $this->redirectToRoute('espace_etudiant_projet_gestion');
        }

        return $this->render('espace_etudiant/projet/creation.html.twig', array(
            'form' => $form->createView()
        ));

}
    }