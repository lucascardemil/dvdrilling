<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizIntervencionChecklist extends Model
{
    use HasFactory;

    protected $table = 'matriz_intervenciones_checklist';

    protected $fillable = [
        'nombre',
        'status',
        'matriz_categoria_checklist_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(MatrizCategoriaChecklist::class, 'matriz_categoria_checklist_id');
    }

    public function observaciones()
    {
        return $this->hasMany(MatrizObservacionChecklist::class);
    }

}
