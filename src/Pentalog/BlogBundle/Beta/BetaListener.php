<?php

namespace Pentalog\BlogBundle\Beta;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener {

    // La date de fin de la version bêta :
    // - Avant cette date, on affichera un compte à rebours (J-3 par exemple)
    // - Après cette date, on n'affichera plus le « bêta »
    protected $finDate;

    public function __construct($finDate) {
        $this->finDate = new \Datetime($finDate);
    }

    // Méthode pour ajouter le « bêta » à une réponse
    protected function displayBeta(Response $reponse, $remainingDays) {
        $content = $response->getContent();

        // Code à rajouter
        $html = '<span style="color: red; font-size: 0.5em;"> - Beta J-' . (int) $remainingDays . ' !</span>';

        // Insertion du code dans la page, dans le <h1> du header
        $content = preg_replace('#<h1>(.*?)</h1>#iU', '<h1>$1' . $html . '</h1>', $content, 1);

        // Modification du contenu dans la réponse
        $response->setContent($content);

        return $response;
    }

    public function onKernelResponse(FilterResponseEvent $event) {
        // On teste si la requête est bien la requête principale
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        // On récupère la réponse que le noyau a insérée dans l'évènement
        $response = $event->getResponse();

        $remainingDays = $this->finDate->diff(new \Datetime())->days;

        if ($remainingDays > 0) {
            $response = $this->displayBeta($event->getResponse(), $remainingDays);
        }

        // Puis on insère la réponse modifiée dans l'évènement
        $event->setResponse($response);

        // On stoppe la propagation de l'évènement en cours (ici, kernel.response)
//        $event->stopPropagation();
    }

}
