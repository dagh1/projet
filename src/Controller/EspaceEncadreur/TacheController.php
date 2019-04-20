<?php

namespace App\Controller\EspaceEncadreur;

use App\Entity\Projet;
use App\Entity\Tache;
use DateInterval;
use DateTimeInterface;
use DateTimeZone;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\TacheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TacheController extends AbstractController
{
    /**
     * @Route("/tache", name="espace_encadreur_tache_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $taches = $em->getRepository(Tache::class)->findAll();

        return $this->render('espace_encadreur/tache/liste.html.twig', array(
            'taches' => $taches
        ));
    }

    /**
     * @Route("/tache/ajouter/projet/{id}", name="espace_encadreur_tache_ajouter")
     */
    public function ajout(Request $request, Projet $projet)
    {
        $tache = new Tache();

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tache->setDateInsert(new \DateTime());
            $tache->setProjet($projet);
            $em->persist($tache);
            $em->flush();

            return $this->redirectToRoute('espace_encadreur_consulter_projet');
        }

        return $this->render('espace_encadreur/tache/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/tache/modifier/{id}", name="espace_encadreur_tache_modifier")
     */
    public function modifier(Request $request,Projet $projet)
    {
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository(Tache::class)->find($projet->getId());

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tache->setProjet($projet);
            $em->flush();
            return $this->redirectToRoute('espace_encadreur_consulter_projet');
        }

        return $this->render('espace_encadreur/tache/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/tache/supprimer/{id}", name="espace_encadreur_tache_supprimer")
     */
    public function supprimer(Request $request,Projet $projet)
    {
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository(Tache::class)->find($projet->getId());

        if($tache)
        {
            $em->remove($tache);
            $em->flush();
        }

        return $this->redirectToRoute('espace_encadreur_consulter_projet');

    }


}
