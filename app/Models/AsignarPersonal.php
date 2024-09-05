<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignarPersonal extends Model
{
    use HasFactory;

    protected $table = 'asignar_personal';

    protected $fillable = [
        'personal_id',
        'proyecto_id',
        'status',
    ];

    // Relación muchos a uno con Personal
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    // Relación muchos a uno con Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

}
