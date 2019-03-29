<?php

namespace App\Controller;

use App\Form\SocieteChercherType;
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
            'form'=> $form->createView()
        ));
    }

}
