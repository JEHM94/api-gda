<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'dni';

    protected $fillable = [
        'dni',
        'email',
        'name',
        'last_name',
        'address',
        'status',
        'region_id',
        'commune_id',
    ];

    // Retorna la descripción de la Región a la que pertenece el Cliente
    public function region()
    {
        return $this->belongsTo(Region::class)->select('description');
    }

    // Retorna la descripción de la Comuna a la que pertenece el Cliente
    public function commune()
    {
        return $this->belongsTo(Commune::class)->select('description');
    }
}
