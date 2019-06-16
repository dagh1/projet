<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Commentaire;
use App\Entity\Etudiant;
use App\Entity\Projet;
use App\Entity\Societe;
use App\Entity\Tache;
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
        $user = $this->getUser();
        $etudiant = $em->getRepository(Etudiant::class)->findOneBy(array('utilisateur' => $user));

        $projets = $em->getRepository(Projet::class)->findBy(array('etudiant'=>$etudiant), array('id'=>'desc'));

        return $this->render('espace_etudiant/projet/liste.html.twig', array(
            'projets' => $projets
        ));
    }

    /**
     * @Route("/projet/voir/{id}", name="espace_etudiant_projet_voir")
     */
    public function voir($id)
    {
        $em = $this->getDoctrine()->getManager();

        $projet = $em->getRepository(Projet::class)->find($id);

        $taches = $em->getRepository(Tache::class)->findBy(array('projet'=>$projet), array('id'=> 'desc'));

        $commentaires = $em->getRepository(Commentaire::class)->findBy(array('projet' => $projet));

        return $this->render('espace_etudiant/projet/voir.html.twig', array(
            'projet' => $projet,
            'taches'=> $taches,
            'commentaires' => $commentaires
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


    /**
     * @Route("/projet/modifier/{id}", name="espace_etudiant_projet_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rapport = $em->getRepository(Projet::class)->find($id);

        $form = $this->createForm(projetType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('espace_etudiant_projet_voir');
        }

        return $this->render('espace_etudiant/projet/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }
}