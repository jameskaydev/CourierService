<?php

namespace App\Interfaces;

interface DeliveryMethodInterface {
    public function shipPackage($package);
}

?>