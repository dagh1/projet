<?php

namespace App\Controller\Administration;

use App\Entity\Projet;
use App\Form\ProjetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    /**
     * @Route("/projet", name="admin_projet_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $projets = $em->getRepository(Projet::class)->findAll();

        return $this->render('administration/projet/liste.html.twig', array(
            'projets' => $projets
        ));
    }

    /**
     * @Route("/projet/ajouter", name="admin_projet_ajouter")
     */
    public function ajout(Request $request)
    {
        $projet = new Projet();

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush();

            return $this->redirectToRoute('admin_projet_liste');
        }

        return $this->render('administration/projet/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/projet/modifier/{id}", name="admin_projet_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository(Projet::class)->find($id);

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_projet_liste');
        }

        return $this->render('administration/projet/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/projet/supprimer/{id}", name="admin_projet_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository(Projet::class)->find($id);

        if($projet)
        {
            $em->remove($projet);
            $em->flush();
        }

        return $this->redirectToRoute('admin_projet_liste');

    }

}
