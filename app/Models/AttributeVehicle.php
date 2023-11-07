<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeVehicle extends Model
{
    use HasFactory;

    protected $table = 'attribute_vehicle';
    protected $fillable = [
        'attribute_id',
        'vehicle_id',
        'value',
    ];
}
