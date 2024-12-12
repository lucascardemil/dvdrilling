<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistVehiculo extends Model
{
    use HasFactory;

    protected $table = 'checklist_vehiculo';

    protected $fillable = [
        'checklist_id',
        'patente',
        'status'
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist');
    }

    public function detalles()
    {
        return $this->hasMany(ChecklistVehiculoDetalle::class);
    }

    public function condiciones()
    {
        return $this->hasMany(ChecklistCondicion::class);
    }
}
