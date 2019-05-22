<?php

namespace App\Controller;


use App\Entity\Evenement;
use App\Form\EtudiantChercherType;
use App\Form\RapportChercherType;
use App\Form\SocieteChercherType;
use App\Form\StageChercherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index()
    {
        return $this->render('accueil.html.twig');
    }

    public function formulaireChercherSociete(Request $request)
    {
        $form = $this->createForm(SocieteChercherType::class);
        $form->handleRequest($request);

        return $this->render('formulaires_recherche/form_recherche_societe.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function formulaireChercherOffreStage(Request $request)
    {
        $form = $this->createForm(StageChercherType::class);
        $form->handleRequest($request);

        return $this->render('formulaires_recherche/form_recherche_offreStage.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function formulaireChercherRapport(Request $request)
    {
        $form = $this->createForm(RapportChercherType::class);
        $form->handleRequest($request);

        return $this->render('formulaires_recherche/form_recherche_rapport.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function formulaireChercherEtudiant(Request $request)
    {
        $form = $this->createForm(EtudiantChercherType::class);
        $form->handleRequest($request);

        return $this->render('formulaires_recherche/form_recherche_etudiant.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("envoyer-email", name="envoyer_email")
     */
    public function mail(Request $request, \Swift_Mailer $mailer)
    {
        $from = $this->getParameter('mailer_user');
        $to = $this->getParameter('mailer_user');

        $email = $request->request->get('email');
        $nom = $request->request->get('nom');
        $contenue = $request->request->get('message');

        $message = (new \Swift_Message('Nouveau email de ' . $nom))
            ->setFrom($from)
            ->setTo($to)
            ->setReplyTo($email)
            ->setBody(
                $this->renderView(
                    'emails/contact.html.tiwg',
                    ['nom' => $nom, 'contenue' => $contenue]
                ),
                'text/html'
            );

        $mailer->send($message);

        $this->addFlash('success', 'Votre message a été bien envoyé');

        return $this->redirect(
            $this->generateUrl('app_index') . '#contact'
        );
    }


}
