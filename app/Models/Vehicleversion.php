<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicleversion extends Model
{
    use HasFactory;

    protected $table = 'vehicle_versions';

    protected $fillable = [
        'id',
        'name',
        'model_id',
    ];
}
