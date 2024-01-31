<?php

namespace App\Http\Controllers;

use App\Interfaces\DeliveryMethodInterface;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected $deliveryMethod;

    public function setDeliveryMethod(DeliveryMethodInterface $deliveryMethod) {
        $this->deliveryMethod = $deliveryMethod;
    }

    public function processShipping($package) {
        // Delegate the shipping process to the selected delivery method
        $this->deliveryMethod->shipPackage($package);
    }
}
