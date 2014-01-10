<?php

// src/Sdz/BlogBundle/Bigbrother/CensureListener.php

namespace Pentalog\BlogBundle\Bigbrother;

use Symfony\Component\Security\Core\User\UserInterface;

class CensureListener {

    // Liste des id des utilisateurs à surveiller
    protected $list;
    protected $mailer;

    public function __construct(array $list, \Swift_Mailer $mailer) {
        $this->list = $list;
        $this->mailer = $mailer;
    }

    // Méthode « reine » 1
    protected function sendEmail($message, UserInterface $user) {
        $message = \Swift_Message::newInstance()
                ->setSubject("Nouveau message d'un utilisateur surveillé")
                ->setFrom('admin@votresite.com')
                ->setTo('admin@votresite.com')
                ->setBody("L'utilisateur surveillé '" . $user->getUsername() . "' a posté le message suivant : '" . $message . "'");

        $this->mailer->send($message);
    }

    // Méthode « reine » 2
    protected function censureMessage($message) {
        // Ici, totalement arbitraire :
        $message = str_replace(array('top secret', 'mot interdit'), '', $message);

        return $message;
    }

    // Méthode « technique » de liaison entre l'évènement et la fonctionnalité reine
    public function onMessagePost(MessagePostEvent $event) {
        // On active la surveillance si l'auteur du message est dans la list
        if (in_array($event->getUser()->getId(), $this->list)) {
            // On envoie un e-mail à l'administrateur
            $this->sendEmail($event->getMessage(), $event->getUser());

            // On censure le message
            $message = $this->censureMessage($event->getMessage());
            // On enregistre le message censuré dans l'event
            $event->setMessage($message);
        }
    }

}
