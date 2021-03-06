<?php

namespace App\Controller\Administration;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/administration", name="admin_index")
     */
    public function index()
    {
        return $this->render('administration/accueil.html.twig');
    }
}
