<?php

namespace App\Http\Controllers\Delivery;

use App\Interfaces\DeliveryMethodInterface;

class PrimeDelivery  implements DeliveryMethodInterface
{
    public function shipPackage($package) {
        // DHL-specific shipping logic
        echo "Shipping via DHL: {$package}\n";
    }
}
