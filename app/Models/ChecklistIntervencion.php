<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistIntervencion extends Model
{
    use HasFactory;

    protected $table = 'checklist_intervenciones';

    protected $fillable = [
        'nombre',
        'status',
        'checklist_categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(ChecklistCategoria::class, 'checklist_categoria_id');
    }

    public function condiciones()
    {
        return $this->hasMany(ChecklistCondicion::class);
    }

    public function observaciones()
    {
        return $this->hasMany(ChecklistObservacion::class);
    }

}
