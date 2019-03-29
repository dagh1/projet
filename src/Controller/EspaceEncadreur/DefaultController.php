<?php

namespace App\Controller\EspaceEncadreur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="espace_encadreur_index")
     */
    public function index()
    {
        return $this->render('espace_encadreur/accueil.html.twig');
    }
}
