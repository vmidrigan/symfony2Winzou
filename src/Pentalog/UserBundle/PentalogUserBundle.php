<?php

namespace Pentalog\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PentalogUserBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }

}
