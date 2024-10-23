<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistObservacionImagen extends Model
{
    use HasFactory;

    protected $table = 'checklist_observacion_imagenes';

    protected $fillable = [
        'imagen',
        'checklist_observacion_id'
    ];

    public function observacion()
    {
        return $this->belongsTo(ChecklistObservacion::class, 'checklist_observacion_id');
    }
}