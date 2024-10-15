<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizObservacionChecklist extends Model
{
    use HasFactory;

    protected $table = 'matriz_observaciones_checklist';

    protected $fillable = [
        'nombre',
        'status',
        'matriz_intervencion_checklist_id'
    ];

    public function intervencion()
    {
        return $this->belongsTo(MatrizIntervencionChecklist::class, 'matriz_intervencion_checklist_id');
    }
}
