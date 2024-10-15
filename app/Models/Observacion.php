<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $table = 'observacion_reporte';

    protected $fillable = [
        'observacion',
        'reporte_id',
    ];


    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }
}
