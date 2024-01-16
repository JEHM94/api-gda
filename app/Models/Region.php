<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status',
    ];

    // Retorna todas las Comunas de una Región
    public function communes()
    {
        return $this->hasMany(Commune::class)->where('status', 'A')->select('id', 'region_id', 'description', 'status');
    }
}
