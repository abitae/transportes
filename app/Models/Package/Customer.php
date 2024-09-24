<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_code',
        'code',
        'name',
        'phone',
        'email',
        'address',
        'isActive',
    ];
    public function encomiendas_remitente()
    {
        return $this->hasMany(Encomienda::class, 'customer_id');
    }
    public function encomiendas_destinatario()
    {
        return $this->hasMany(Encomienda::class, 'customer_dest_id');
    }
}
