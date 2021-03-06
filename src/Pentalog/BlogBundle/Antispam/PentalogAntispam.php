<?php

namespace Pentalog\BlogBundle\Antispam;

class PentalogAntispam extends \Twig_Extension {

    protected $mailer;
    protected $locale;
    protected $nbForSpam;

    public function __construct(\Swift_Mailer $mailer, $nbForSpam) {
        $this->mailer = $mailer;
        $this->nbForSpam = (int) $nbForSpam;
    }

    public function setLocale($locale) {
        $this->locale = $locale;
    }

    /**
     * Vérifie si le texte est un spam ou non
     * Un texte est considéré comme spam à partir de 3 liens
     * ou adresses e-mail dans son contenu
     *
     * @param string $text
     */
    public function isSpam($text) {
        // On utilise maintenant l'argument $this->nbForSpam et non plus le « 3 » en dur :
        return ($this->countLinks($text) + $this->countMails($text)) >= $this->nbForSpam;
    }

    /**
     * Compte les URL de $text
     *
     * @param string $text
     */
    private function countLinks($text) {
        preg_match_all(
                '#(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?#i', $text, $matches);

        return count($matches[0]);
    }

    /**
     * Compte les e-mails de $text
     *
     * @param string $text
     */
    private function countMails($text) {
        preg_match_all(
                '#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#i', $text, $matches);

        return count($matches[0]);
    }

    /*
     * Twig va exécuter cette méthode pour savoir quelle(s) fonction(s) ajoute notre service
     */

    public function getFunctions() {
        return array(
            'checkIfSpam' => new \Twig_Function_Method($this, 'isSpam')
        );
    }

    /*
     * La méthode getName() identifie votre extension Twig, elle est obligatoire
     */

    public function getName() {
        return 'PentalogAntispam';
    }

}
