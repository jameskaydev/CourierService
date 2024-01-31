<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class validateDelivery implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    private $shippingMethods = [
        'DHL',
        'Prime',
    ];
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!in_array($value,$this->shippingMethods)){
            $fail('We don\'t support this shipping method.');
        }
    }
}
