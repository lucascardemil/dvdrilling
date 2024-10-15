<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perforacion extends Model
{
    use HasFactory;

    protected $table = 'perforacion_reporte';

    protected $fillable = [
        'desde',
        'hasta',
        'perforado',
        'recuperado',
        'porcentaje',
        'numero_cajas',
        'status',
        'reporte_id'
    ];


    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }
}
