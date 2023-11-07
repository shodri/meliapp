<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'model_id',
        'version_id',
        'currency_id',
        'fuel_id',
        'location_id',
        'segment_id',
        'title',
        'color',
        'kilometers',
        'price',
        'year',
        'license_plate',
        'motor',
        'doors',
        'steering',
        'traccion',
        'condition',
        'attributes',
        'status',
        'created_at',
        'updated_at',
        'description',
        'comments',
        'status',
        'meli_link',
        'listing_type_id',
        'meli_id',
    ];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function brand()
    {
        return $this->belongsTo(Vehiclebrand::class);
    }

    public function model()
    {
        return $this->belongsTo(Vehiclemodel::class);
    }

    public function version()
    {
        return $this->belongsTo(Vehicleversion::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function fuel()
    {
        return $this->belongsTo(Fuel::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }
}
