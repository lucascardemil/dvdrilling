<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizChecklist extends Model
{
    use HasFactory;

    protected $table = 'matriz_checklist';

    protected $fillable = [
        'nombre',
        'status'
    ];

    public function categorias()
    {
        return $this->hasMany(MatrizCategoriaChecklist::class);
    }

    public function checklist()
    {
        return $this->hasMany(Checklist::class);
    }
}
