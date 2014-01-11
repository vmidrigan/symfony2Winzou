<?php

// src/Sdz/BlogBundle/Event/TestSubscriber.php

namespace Pentalog\BlogBundle\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class TestSubscriber implements EventSubscriberInterface {

    // La méthode de l'interface que l'on doit implémenter, à définir en static
    static public function getSubscribedEvents() {
        // On retourne un tableau « nom de l'évènement » => « méthode à exécuter »
        return array(
            'kernel.response' => 'onKernelResponse',
            'store.order' => 'onStoreOrder',
        );
    }

    public function onKernelResponse(FilterResponseEvent $event) {
        // …
    }

    public function onStoreOrder(FilterOrderEvent $event) {
        // …
    }

}


//// Depuis un contrôleur ou autre
//
//use Pentalog\BlogBundle\Event\TestSubscriber;
//
//// On récupère le gestionnaire d'évènements
//$dispatcher = $this->get('event_dispatcher');
//
//// On instancie notre souscripteur
//$subscriber = new TestSubscriber();
//
//// Et on le déclare au gestionnaire d'évènements
//$dispatcher->addSubscriber($subscriber);