<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntervencionChecklist extends Model
{
    use HasFactory;

    protected $table = 'intervenciones_checklist';

    protected $fillable = [
        'checklist_id',
        'matriz_categorias_checklist_id',
        'matriz_intervencion_checklist_id',
        'status'
    ];
}
