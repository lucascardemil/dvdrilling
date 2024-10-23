<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistCategoria extends Model
{
    use HasFactory;

    protected $table = 'checklist_categorias';

    protected $fillable = [
        'nombre',
        'status',
        'checklist_id'
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist');
    }

    public function intervenciones()
    {
        return $this->hasMany(ChecklistIntervencion::class);
    }
}
