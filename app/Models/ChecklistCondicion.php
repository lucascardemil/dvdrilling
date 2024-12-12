<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistCondicion extends Model
{
    use HasFactory;

    protected $table = 'checklist_condiciones';

    protected $fillable = [
        'existe',
        'estado',
        'status',
        'checklist_intervencion_id',
        'checklist_vehiculo_id',
        'checklist_vehiculo_detalle_id'
    ];

    public function intervencion()
    {
        return $this->belongsTo(ChecklistIntervencion::class, 'checklist_intervencion_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(ChecklistVehiculo::class, 'checklist_vehiculo_id');
    }

    public function detalle()
    {
        return $this->belongsTo(ChecklistVehiculoDetalle::class, 'checklist_vehiculo_detalle_id');
    }

    public function imagenes()
    {
        return $this->hasMany(ChecklistObservacion::class);
    }
}
