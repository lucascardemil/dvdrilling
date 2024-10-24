<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizChecklistCategoria extends Model
{
    use HasFactory;

    protected $table = 'matriz_checklist_categorias';

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
        return $this->hasMany(MatrizChecklistIntervencion::class);
    }
}
