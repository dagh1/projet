<?php

namespace App\Controller\Account;

use App\Form\UserChangeEmailType;
use App\Form\UserChangePasswordType;
use App\Form\UserAccountType;
use App\Form\UserPhoneType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AccountController
 * @package App\Controller\Account
 *
 * @Route("/account")
 */
class AccountController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="account_edit")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function edit(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Modifiaction avec succés.');
        }
        return $this->render('account/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/email", name="account_email")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function email(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserChangeEmailType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $currentEmail = $user->getEmail();
            $newEmail = $form->get('email')->getData();
            $currentPassword = $form->get('currentPassword')->getData();

            // verify if the password is correct
            $verify = $this->verify($currentPassword, $user->getPassword());
            if ($verify === false) {
                $form->get('currentPassword')->addError(new FormError('Mot de passe incorrect.'));
            }

            if ($form->isValid()) {
                $this->addFlash('success', 'L\'email a été modifié avec succés.');
                $user->setEmail($newEmail);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $em->refresh($user);
                return $this->redirectToRoute('account_email');
            }
        }

        return $this->render('account/email.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/password", name="account_password")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function password(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $currentPassword = $form->get('currentPassword')->getData();
            $verify = $this->verify($currentPassword, $user->getPassword());

            if (false === $currentPassword || empty($currentPassword)) {
                $form->get('currentPassword')->addError(new FormError('Mot de passe ne doit pas être vide.'));
            }

            if ($verify === false) {
                $form->get('currentPassword')->addError(new FormError('Mot de passe incorrect.'));
            }

            if ($form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
                $user->setPassword($password);
                $this->addFlash('success', 'Le mot de passe a été modifié avec succés.');
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $em->refresh($user);
                return $this->redirectToRoute('account_password');
            }
        }

        return $this->render('account/password.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function verify($input, $existingHash)
    {
        $hash = password_verify($input, $existingHash);

        return $hash === true;
    }


}