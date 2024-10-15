<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignarActivo extends Model
{
    use HasFactory;

    protected $table = 'asignar_activos';

    protected $fillable = [
        'activo_id',
        'proyecto_id',
        'status',
    ];

    // Relación muchos a uno con activo
    public function activo()
    {
        return $this->belongsTo(Activo::class, 'activo_id');
    }

    // Relación muchos a uno con Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

}
