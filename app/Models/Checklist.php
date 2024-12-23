<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $table = 'checklist';

    protected $fillable = [
        'marca',
        'modelo',
        'horometro',
        'status',
        'user_id',
        'tipo_activo_id',
        'matriz_checklist_id'
    ];

    public function tipoactivo()
    {
        return $this->belongsTo(TipoActivo::class, 'tipo_activo_id');
    }

    public function categorias()
    {
        return $this->hasMany(ChecklistCategoria::class);
    }

    public function matriz()
    {
        return $this->belongsTo(MatrizChecklist::class, 'matriz_checklist_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehiculos()
    {
        return $this->hasMany(ChecklistVehiculo::class);
    }
}
