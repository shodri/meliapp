<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiclemodel extends Model
{
    use HasFactory;

    protected $table = 'vehicle_models';

    protected $fillable = [
        'id',
        'name',
        'brand_id',
    ];
    
    public function brand()
    {
        return $this->hasOne(Vehiclebrand::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

}
