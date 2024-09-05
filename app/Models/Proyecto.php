<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'name',
        'status',
    ];

    public function asignaciones()
    {
        return $this->hasMany(AsignarPersonal::class, 'proyecto_id');
    }
}
