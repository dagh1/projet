<?php

namespace App\Controller\EspaceEtudiant;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="espace_etudiant_index")
     */
    public function index()
    {
        return $this->render('espace_etudiant/accueil.html.twig');
    }
}
