<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistCondicion extends Model
{
    use HasFactory;

    protected $table = 'checklist_condiciones';

    protected $fillable = [
        'existe',
        'estado',
        'status',
        'checklist_intervencion_id'
    ];

    public function intervencion()
    {
        return $this->belongsTo(ChecklistIntervencion::class, 'checklist_intervenciones');
    }
}
