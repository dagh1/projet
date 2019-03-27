<?php

namespace App\Controller\Administration;

use App\Entity\Tache;
use App\Form\TacheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TacheController extends AbstractController
{
    /**
     * @Route("/tache", name="admin_tache_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $taches = $em->getRepository(Tache::class)->findAll();

        return $this->render('administration/tache/liste.html.twig', array(
            'taches' => $taches
        ));
    }

    /**
     * @Route("/tache/ajouter", name="admin_tache_ajouter")
     */
    public function ajout(Request $request)
    {
        $tache = new Tache();

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tache);
            $em->flush();

            return $this->redirectToRoute('admin_tache_liste');
        }

        return $this->render('administration/tache/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/tache/modifier/{id}", name="admin_tache_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository(Tache::class)->find($id);

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_tache_liste');
        }

        return $this->render('administration/tache/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/tache/supprimer/{id}", name="admin_tache_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository(Tache::class)->find($id);

        if($tache)
        {
            $em->remove($tache);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tache_liste');

    }


}
