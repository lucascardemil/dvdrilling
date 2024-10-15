<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    use HasFactory;

    protected $table = 'herramienta_reporte';

    protected $fillable = [
        'barras_3',
        'barras_3_5',
        'barril',
        'total_barril',
        'muerto',
        'contra',
        'f_inicio',
        'f_termino',
        'recuperacion',
        'status',
        'reporte_id',
    ];


    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }
}
