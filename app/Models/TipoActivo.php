<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoActivo extends Model
{
    use HasFactory;

    protected $table = 'tipo_activos';

    protected $fillable = [
        'name',
        'status',
    ];

    public function activos()
    {
        return $this->hasMany(Activo::class);
    }
}
