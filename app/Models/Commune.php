<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'description',
        'status',
    ];

    // Retorna la información de la Región a la que pertenece la Comuna
    public function region()
    {
        return $this->belongsTo(Region::class)->select('id', 'description', 'status');
    }
}
