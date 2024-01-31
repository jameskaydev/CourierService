<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait InputValidation{
    public static function GENERAL(){
        return [
            'parcels.*.width.required' => "width is required",
            'parcels.*.height.required' => "height is required",
            'parcels.*.length.required' => "length is required",
            'parcels.*.weight.required' => "weight is required",

        ];
    }
}
