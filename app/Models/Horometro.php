<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horometro extends Model
{
    use HasFactory;

    protected $table = 'horometro_reporte';

    protected $fillable = [
        'inicio',
        'termino',
        'numero_cajas',
        'status',
        'reporte_id',
    ];


    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }
}
