<?php

namespace App\Models\Configuration;

use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    public function encomiendas()
    {
        return $this->hasMany(Encomienda::class);
    }
}
