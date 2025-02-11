<?php

namespace App\Models\Configuration;

use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'marca',
        'modelo',
        'tipo',
        'isActive',
    ];
    public function encomiendas()
    {
        return $this->hasMany(Encomienda::class);
    }
    public function sucursal_configurations()
    {
        return $this->hasMany(SucursalConfiguration::class);
    }
}
