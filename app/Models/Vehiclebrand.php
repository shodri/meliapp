<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiclebrand extends Model
{
    use HasFactory;
    protected $table = 'vehicle_brands';
    protected $fillable = [
        'id',
        'name',
    ];
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function models()
    {
        return $this->hasMany(Vehiclemodel::class, 'brand_id');
    }
}
