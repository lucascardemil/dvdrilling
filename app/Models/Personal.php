<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personals';

    protected $fillable = [
        'name',
        'apellido_paterno',
        'apellido_materno',
        'run',
        'cargo_id',
        'status',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignarPersonal::class, 'personal_id');
    }
}
