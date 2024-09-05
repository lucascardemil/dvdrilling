<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivoImagen extends Model
{
    use HasFactory;

    protected $table = 'activo_imagenes';

    protected $fillable = [
        'ruta',
        'status',
        'activo_id'
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'activo_id');
    }
}
