<?php

namespace App\Models\Configuration;

use App\Models\Package\Encomienda;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'address',
        'phone',
        'email',
        'isActive',
    ];
    public function encomiendas_remitente()
    {
        return $this->hasMany(Encomienda::class, 'customer_id','id');
    }
    public function encomiendas_destinatario()
    {
        return $this->hasMany(Encomienda::class, 'customer_dest_id','id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
