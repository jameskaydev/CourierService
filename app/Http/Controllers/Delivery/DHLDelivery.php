<?php

namespace App\Http\Controllers\Delivery;

use App\Interfaces\DeliveryMethodInterface;
use Illuminate\Http\Request;

class DHLDelivery implements DeliveryMethodInterface
{
    public function shipPackage($package) {
        // DHL-specific shipping logic
        echo "Shipping via DHL: {$package}\n";
    }
}
