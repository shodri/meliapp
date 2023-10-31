<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'redirect',
        'status',
    ];
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
