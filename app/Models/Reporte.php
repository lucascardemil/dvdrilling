<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'proyecto_id',
        'empresa',
        'sondaje',
        'fecha',
        'sonda',
        'turno',
        'horas',
        'desde',
        'hasta',
        'total',
        'adicional',
        'inclinacion',
        'rumbo',
        'programa',
        'diametro'
    ];


    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function horometro()
    {
        return $this->hasMany(Horometro::class);
    }

    public function corona_escareador()
    {
        return $this->hasMany(CoronaEscareador::class);
    }

    public function aditivo()
    {
        return $this->hasMany(Aditivo::class);
    }

    public function herramienta()
    {
        return $this->hasMany(Herramienta::class);
    }

    public function perforacion()
    {
        return $this->hasMany(Perforacion::class);
    }
    
    public function detallehora()
    {
        return $this->hasMany(DetalleHora::class);
    }

    public function observacion()
    {
        return $this->hasMany(Observacion::class);
    }
}
