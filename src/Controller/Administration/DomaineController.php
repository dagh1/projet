<?php

namespace App\Controller\Administration;

use App\Entity\Domaine;
use App\Form\DomaineType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DomaineController extends AbstractController
{
    /**
     * @Route("/domaine", name="admin_domaine_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $domaines = $em->getRepository(Domaine::class)->findAll();

        return $this->render('administration/domaine/liste.html.twig', array(
            'domaines' => $domaines
        ));
    }

    /**
     * @Route("/domaine/ajouter", name="admin_domaine_ajouter")
     */
    public function ajout(Request $request)
    {
        $domaine = new Domaine();

        $form = $this->createForm(DomaineType::class, $domaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($domaine);
            $em->flush();

            return $this->redirectToRoute('admin_domaine_liste');
        }

        return $this->render('administration/domaine/ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/domaine/modifier/{id}", name="domaine_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $domaine = $em->getRepository(Domaine::class)->find($id);

        $form = $this->createForm(DomaineType::class, $domaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_domaine_liste');
        }

        return $this->render('administration/domaine/modifier.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/domaine/supprimer/{id}", name="admin_domaine_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $domaine = $em->getRepository(Domaine::class)->find($id);

        if($domaine)
        {
            $em->remove($domaine);
            $em->flush();
        }

        return $this->redirectToRoute('admin_domaine_liste');

    }


}
