<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleHora extends Model
{
    use HasFactory;

    protected $table = 'detalle_horas_reporte';

    protected $fillable = [
        'de',
        'a',
        'actividad_id',
        'status',
        'reporte_id'
    ];


    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }
}
