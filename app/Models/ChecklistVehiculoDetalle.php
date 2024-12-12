<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistVehiculoDetalle extends Model
{
    use HasFactory;

    protected $table = 'checklist_vehiculo_detalle';

    protected $fillable = [
        'checklist_vehiculo_id',
        'status',
        'conductor',
        'kilometraje_inicial',
        'kilometraje_final',
        'horometro_inicial',
        'horometro_final',
        'numero_interno',
        'proyecto',
        'faena',
        'turno',
        'litros',
        'observacion_bitacora',
        'carga_combustible',
        'estado_equipo',
        'imagen_combustible'
    ];


    public function vehiculos()
    {
        return $this->belongsTo(ChecklistVehiculo::class, 'checklist_vehiculo_id');
    }


    public function condiciones()
    {
        return $this->hasMany(ChecklistCondicion::class);
    }
}
