<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class validateParcels implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    private $required = [
        'width',
        'height',
        'length',
        'weight'
    ];
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        foreach($this->required as $index){
            if (!array_key_exists($index, $value)) {
                $fail('The '. $index .' is required!');
            }
        }
        
    }
}
