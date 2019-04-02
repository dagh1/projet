<?php

namespace App\Controller\Administration;

use App\Entity\Encadreur;
use App\Form\EncadreurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EncadreurController extends AbstractController
{
    /**
     * @Route("/encadreur", name="admin_encadreur_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $encadreurs = $em->getRepository(Encadreur::class)->findAll();

        return $this->render('administration/encadreur/liste.html.twig', array(
            'encadreurs' => $encadreurs
        ));
    }

    /**
     * @Route("/encadreur/ajouter", name="admin_encadreur_ajouter")
     */



    /**
     * @Route("/encadreur/modifier/{id}", name="encadreur_modifier")
     */


    /**
     * @Route("/encadreur/supprimer/{id}", name="admin_encadreur_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $encadreur = $em->getRepository(Encadreur::class)->find($id);

        if($encadreur)
        {
            $em->remove($encadreur);
            $em->flush();
        }

        return $this->redirectToRoute('admin_encadreur_liste');

    }


}
