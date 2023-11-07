<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'country',
        'country_id',
        'state',
        'state_id',
        'city',
        'city_id',
        'zip_code',
        'lat',
        'long',
        'seller',
        'telephone',
        'email',
        'meli_id',
    ];
}
