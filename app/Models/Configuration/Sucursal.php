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
        'name',
        'address',
        'phone',
        'email',
        'isActive',
    ];
    public function sucursals_remitente()
    {
        return $this->hasMany(Encomienda::class, 'customer_id');
    }
    public function sucursals_destinatario()
    {
        return $this->hasMany(Encomienda::class, 'customer_dest_id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
