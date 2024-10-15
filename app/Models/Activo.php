<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    use HasFactory;

    protected $table = 'activos';

    protected $fillable = [
        'marca',
        'modelo',
        'patente',
        'numero_interno',
        'year',
        'horometro',
        'kilometraje',
        'color',
        'chasis',
        'numero_motor',
        'tipo_activo_id',
        'status'
    ];

    public function tipo_activo()
    {
        return $this->belongsTo(TipoActivo::class);
    }

    public function imagenes()
    {
        return $this->hasMany(ActivoImagen::class, 'activo_id');
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignarActivo::class, 'activo_id');
    }

    public function checklist()
    {
        return $this->hasMany(Checklist::class);
    }
}
