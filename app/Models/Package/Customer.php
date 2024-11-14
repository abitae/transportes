<?php

namespace App\Models\Package;

use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Ticket;
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
        return $this->hasMany(Encomienda::class, 'customer_id','id');
    }
    public function encomiendas_destinatario()
    {
        return $this->hasMany(Encomienda::class, 'customer_dest_id','id');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
