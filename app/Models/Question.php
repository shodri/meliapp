<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date_created',
        'item_id',
        'status',
        'text',
        'from',
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'meli_id', 'item_id');
    }
}
