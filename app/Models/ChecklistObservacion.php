<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistObservacion extends Model
{
    use HasFactory;

    protected $table = 'checklist_observaciones';

    protected $fillable = [
        'observacion',
        'checklist_intervencion_id'
    ];

    public function intervencion()
    {
        return $this->belongsTo(ChecklistIntervencion::class, 'checklist_intervencion_id');
    }

    public function imagenes()
    {
        return $this->hasMany(ChecklistObservacionImagen::class);
    }
}
