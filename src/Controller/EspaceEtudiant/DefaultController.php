<?php

namespace App\Controller\EspaceEtudiant;

use App\Entity\Etudiant;
use App\Entity\Evenement;
use App\Entity\Notification;
use App\Entity\Projet;
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


    public function nav()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $etudiant = $em->getRepository(Etudiant::class)->findOneBy(array('utilisateur' => $user));
        $projets = $em->getRepository(Projet::class)->findBy(array('etudiant'=>$etudiant), array('id'=>'desc'));

        return $this->render('espace_etudiant/includes/nav.html.twig', array(
            'projest'=> $projets
        ));
    }

    public function notifications()
    {
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository(Evenement::class)->today($this->getUser());
        $notifications = $em->getRepository(Notification::class)->findBy(array('utilisateur' => $this->getUser()), array('id' => 'desc'), 4,0);

        $nbNotificationsNonVu = $em->getRepository(Notification::class)->nbNonVu($this->getUser());
        $totalNotif = count($evenements) + $nbNotificationsNonVu;

        return $this->render('espace_etudiant/includes/notifications.html.tiwg', array(
            'evenements' => $evenements,
            'notifications' => $notifications,
            'totalNotif'=> $totalNotif
        ));
    }


    /**
     * @Route("/notifications", name="espace_etudiant_notifications")
     */
    public function mesNotifications()
    {
        $em = $this->getDoctrine()->getManager();

        $notifications = $em->getRepository(Notification::class)->findBy(array('utilisateur' => $this->getUser()), array('id' => 'desc'));
        foreach ($notifications as $notification){
            $notification->setVu(true);
        }
        $em->flush();

        return $this->redirectToRoute('espace_etudiant_index');
        return $this->render('espace_etudiant/notification/liste.html.tiwg', array(
            'notifications' => $notifications,

        ));
    }
}
