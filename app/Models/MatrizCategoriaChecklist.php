<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizCategoriaChecklist extends Model
{
    use HasFactory;

    protected $table = 'matriz_categorias_checklist';

    protected $fillable = [
        'nombre',
        'status',
        'matriz_checklist_id'
    ];

    public function matrizChecklist()
    {
        return $this->belongsTo(MatrizChecklist::class, 'matriz_checklist_id');
    }

    public function intervenciones()
    {
        return $this->hasMany(MatrizIntervencionChecklist::class);
    }
}
