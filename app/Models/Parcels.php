<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcels extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'width',
        'height',
        'length',
        'weight',
        'delivery_address_id',
        'sender_address_id',
    ];
}
