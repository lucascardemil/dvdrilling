<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizChecklistIntervencion extends Model
{
    use HasFactory;

    protected $table = 'matriz_checklist_intervenciones';

    protected $fillable = [
        'nombre',
        'status',
        'matriz_checklist_categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(MatrizChecklistCategoria::class, 'matriz_checklist_categoria_id');
    }

}
