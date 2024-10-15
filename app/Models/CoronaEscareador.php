<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoronaEscareador extends Model
{
    use HasFactory;

    protected $table = 'corona_escareador_reporte';

    protected $fillable = [
        'detalle',
        'desde',
        'hasta',
        'numero_corona',
        'diametro',
        'status',
        'reporte_id',
    ];


    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }
}
