<?php

namespace App\Controller\EspaceEncadreur;

use App\Entity\Evenement;
use App\Entity\Notification;
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


    public function notifications()
    {
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository(Evenement::class)->today($this->getUser());
        $notifications = $em->getRepository(Notification::class)->findBy(array('utilisateur' => $this->getUser()), array('id' => 'desc'), 4,0);

        $nbNotificationsNonVu = $em->getRepository(Notification::class)->nbNonVu($this->getUser());
        $totalNotif = count($evenements) + $nbNotificationsNonVu;

        return $this->render('espace_encadreur/includes/notifications.html.tiwg', array(
            'evenements' => $evenements,
            'notifications' => $notifications,
            'totalNotif'=> $totalNotif
        ));
    }

    /**
     * @Route("/notifications", name="espace_encadreur_notifications")
     */
    public function mesNotifications()
    {
        $em = $this->getDoctrine()->getManager();

        $notifications = $em->getRepository(Notification::class)->findBy(array('utilisateur' => $this->getUser()), array('id' => 'desc'));
        foreach ($notifications as $notification){
            $notification->setVu(true);
        }
        $em->flush();


        return $this->render('espace_encadreur/notification/liste.html.tiwg', array(
            'notifications' => $notifications,

        ));
    }
}
