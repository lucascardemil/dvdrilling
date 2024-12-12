<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistObservacion extends Model
{
    use HasFactory;

    protected $table = 'checklist_observaciones';

    protected $fillable = [
        'imagen',
        'observacion',
        'checklist_condicion_id'
    ];

    public function observacion()
    {
        return $this->belongsTo(ChecklistCondicion::class, 'checklist_condicion_id');
    }
}