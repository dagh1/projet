<?php

namespace App\Controller;

use App\Entity\Encadreur;
use App\Entity\Etudiant;
use App\Entity\Utilisateur;
use App\Form\EncadreurType;
use App\Form\EtudiantType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription/etudiant", name="inscription_etudiant")
     */
    public function registerEtudiant(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $encadreur = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $encadreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $utilisateur = $encadreur->getUtilisateur();
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword(
                    $utilisateur,
                    $form->get('utilisateur')->get('plainPassword')->getData()
                )
            );
            $utilisateur->setRoles(array('ROLE_ETUDIANT'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($encadreur);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $utilisateur,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('inscription/inscription_etudiant.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription/encadreur", name="inscription_encadreur")
     */
    public function registerEcadreur(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $encadreur = new Encadreur();
        $form = $this->createForm(EncadreurType::class, $encadreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $utilisateur = $encadreur->getUtilisateur();
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword(
                    $utilisateur,
                    $form->get('utilisateur')->get('plainPassword')->getData()
                )
            );
            $utilisateur->setRoles(array('ROLE_ENCADREUR'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($encadreur);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $utilisateur,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('inscription/inscription_encadreur.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
