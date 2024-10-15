<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aditivo extends Model
{
    use HasFactory;

    protected $table = 'aditivo_reporte';

    protected $fillable = [
        'cantidad',
        'detalle',
        'status',
        'reporte_id',
    ];


    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }
}
