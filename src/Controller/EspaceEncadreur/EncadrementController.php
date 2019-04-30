<?php

namespace App\Controller\EspaceEncadreur;

use App\Entity\Commentaire;
use App\Entity\Encadrement;
use App\Entity\Encadreur;
use App\Entity\Etudiant;
use App\Entity\Projet;
use App\Entity\Tache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EncadrementController
 * @package App\Controller\EspaceEncadreur
 *
 * @Route("/encadrement")
 */
class EncadrementController extends AbstractController
{
    /**
     * @Route("/", name="espace_encadreur_encadrement_liste")
     * @Security("is_granted('ROLE_ENCADREUR')")
     */
    public function liste(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $encadreur = $em->getRepository(Encadreur::class)->findOneBy(array('utilisateur' => $user));

        $encadrements = $em->getRepository(Encadrement::class)->findBy(array('encadreur' => $encadreur), array('id' => 'desc'));

        return $this->render('espace_encadreur/etudiant/liste.html.twig', array(
                'encadrements' => $encadrements,
            )
        );
    }

    /**
     * @Route("/ajouter/{id}", name="espace_encadreur_encadrement_ajouter")
     * @Security("is_granted('ROLE_ENCADREUR')")
     */
    public function ajouter(Request $request, Etudiant $etudiant)
    {
        if ($request->isXmlHttpRequest() && $request->getMethod() === 'POST') {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $encadreur = $em->getRepository(Encadreur::class)->findOneBy(array('utilisateur' => $user));

            $etudiantEnListe = $em->getRepository(Encadrement::class)->findOneBy(array(
                'encadreur' => $encadreur, 'etudiant' => $etudiant
            ));

            if (!$etudiantEnListe) {
                $encadrement = new Encadrement();
                $encadrement->setEncadreur($encadreur);
                $encadrement->setEtudiant($etudiant);
                $em->persist($encadrement);
                $em->flush();
                $this->addFlash('success', 'Ajouté à votre liste');
            }
        }
        return new JsonResponse();
    }

    /**
     * @Route("/supprimer/{id}", name="espace_encadreur_encadrement_supprimer")
     * @Security("is_granted('ROLE_ENCADREUR')")
     */
    public function supprimer(Request $request, Etudiant $etudiant)
    {
        if ($request->isXmlHttpRequest() && $request->getMethod() === 'POST') {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $encadreur = $em->getRepository(Encadreur::class)->findOneBy(array('utilisateur' => $user));

            $etudiantEnListe = $em->getRepository(Encadrement::class)->findOneBy(array(
                'encadreur' => $encadreur, 'etudiant' => $etudiant
            ));

            if ($etudiantEnListe) {
                $em->remove($etudiantEnListe);
                $em->flush();
                $this->addFlash('error', 'Retiré de votre liste');
            }
        }
        return new JsonResponse();
    }


    /**
     * @Route("/mesEtudiants", name="espace_encadreur_mesetudiants")
     * @Security("is_granted('ROLE_ENCADREUR')")
     */
    public function listeconsulter(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $encadreur = $em->getRepository(Encadreur::class)->findOneBy(array('utilisateur' => $user));

        $encadrements = $em->getRepository(Encadrement::class)->findBy(array('encadreur' => $encadreur), array('id' => 'desc'));
        return $this->render('espace_encadreur/etudiant/mesetudiant.html.twig', array(
                'encadrements' => $encadrements,
            )
        );
    }

    /**
     * @Route("/consulter/etudiant/{id}", name="espace_encadreur_consulter")
     * @Security("is_granted('ROLE_ENCADREUR')")
     */
    public function listeProjets(Request $request, Etudiant $etudiant)
    {
        $em = $this->getDoctrine()->getManager();
        $projets = $em->getRepository(Projet::class)->findBy(array('etudiant' => $etudiant), array('id' => 'desc'));

        return $this->render('espace_encadreur/etudiant/consulter.html.twig', array(
                'projets' => $projets
            )
        );
    }

    /**
     * @Route("/consulter/projet/{id}", name="espace_encadreur_consulter_projet")
     * @Security("is_granted('ROLE_ENCADREUR')")
     */
    public function voir($id)
    {
        $em = $this->getDoctrine()->getManager();

        $projet = $em->getRepository(Projet::class)->find($id);

        $taches = $em->getRepository(Tache::class)->findBy(array('projet' => $projet), array('id' => 'desc'));
        $commentaires = $em->getRepository(Commentaire::class)->findBy(array('projet' => $projet));

        return $this->render('espace_encadreur/etudiant/projet.html.twig', array(
            'projet' => $projet,
            'taches' => $taches,
            'commentaires' => $commentaires
        ));
    }
}
