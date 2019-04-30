<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{

    /**
     * @Route("/commentaire/creer", name="espace_etudiant_encadreur_commentaire")
     */

    public function ajout(Request $request)
    {
        if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $idProjet = $request->request->get('idProjet');
            $message = $request->request->get('message');

            $projet = $em->getRepository(Projet::class)->find($idProjet);

            $commentaire = new Commentaire();
            $commentaire->setProjet($projet);
            $commentaire->setDescription($message);
            $commentaire->setUtilisateur($this->getUser());
            $em->persist($commentaire);
            $em->flush();

            $view = $this->renderView('commentaire/commentaire.html.twig', array(
                'commentaire' => $commentaire
            ));
            return new JsonResponse(array(
                'view' => $view,
                'success' => true
            ));
        }

        return new JsonResponse(array(
            'success' => false
        ));

    }

}