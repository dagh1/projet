<?php

namespace App\Controller\Administration;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="admin_etudiant_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $etudiants = $em->getRepository(Etudiant::class)->findAll();

        return $this->render('administration/etudiant/liste.html.twig', array(
            'etudiants' => $etudiants
        ));
    }

    /**
     * @Route("/etudiant/ajouter", name="admin_etudiant_ajouter")
     */



    /**
     * @Route("/etudiant/modifier/{id}", name="etudiant_modifier")
     */


    /**
     * @Route("/etudiant/supprimer/{id}", name="admin_etudiant_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $etudiant = $em->getRepository(Etudiant::class)->find($id);

        if($etudiant)
        {
            $em->remove($etudiant);
            $em->flush();
        }

        return $this->redirectToRoute('admin_etudiant_liste');

    }


}
