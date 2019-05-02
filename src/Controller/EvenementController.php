<?php

namespace App\Controller;

use App\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $evenements = $em->getRepository(Evenement::class)->findBy(array('utilisateur' => $this->getUser()));
        $format = 'Y-m-d H:i:s';
        foreach ($evenements as $row) {
            $data[] = array(
                'id' => $row->getId(),
                'title' => $row->getTitre(),
                'start' => $row->getDateDebut()->format($format),
                'end' => $row->getDateFin()->format($format),
            );
        }
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/evenement/ajouter", name="evenement_ajouter")
     */
    public function ajout(Request $request)
    {
        $format = 'Y-m-d H:i:s';
        $dateDebut = \DateTime::createFromFormat($format, $request->request->get('start'));
        $dateFin = \DateTime::createFromFormat($format, $request->request->get('end'));

        $titre = $request->request->get('title');

        $evenement = new Evenement();
        $evenement->setTitre($titre);
        $evenement->setDateDebut($dateDebut);
        $evenement->setDateFin($dateFin);
        $evenement->setUtilisateur($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($evenement);
        $em->flush();

        return new JsonResponse();
    }


    /**
     * @Route("/evenement/modifier", name="evenement_modifier")
     */
    public function modifier(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->find($id);

        $format = 'Y-m-d H:i:s';
        $dateDebut = \DateTime::createFromFormat($format, $request->request->get('start'));
        $dateFin = \DateTime::createFromFormat($format, $request->request->get('end'));

        $titre = $request->request->get('title');
        $evenement->setTitre($titre);
        $evenement->setDateDebut($dateDebut);
        $evenement->setDateFin($dateFin);
        $em->flush();

        return new JsonResponse();


    }

    /**
     * @Route("/evenement/supprimer", name="evenement_supprimer")
     */
    public function supprimer(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->find($id);

        $em->remove($evenement);
        $em->flush();

        return new JsonResponse();

    }


}
