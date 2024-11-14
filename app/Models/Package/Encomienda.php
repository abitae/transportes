<?php

namespace App\Models\Package;

use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Facturacion\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomienda extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'user_id',
        'transportista_id',
        'vehiculo_id',
        'customer_id',
        'sucursal_id',
        'customer_dest_id',
        'sucursal_dest_id',
        'customer_fact_id',
        'cantidad',
        'monto',
        'estado_pago',
        'tipo_pago',
        'tipo_comprobante',
        'doc_traslado',
        'glosa',
        'observation',
        'estado_encomienda',
        'pin',
        'isHome',
        'isReturn',
        'isActive'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transportista()
    {
        return $this->belongsTo(Transportista::class);
    }
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
    public function remitente()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function sucursal_remitente()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id', 'id');
    }
    public function destinatario()
    {
        return $this->belongsTo(Customer::class, 'customer_dest_id', 'id');
    }
    public function sucursal_destinatario()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_dest_id', 'id');
    }
    public function paquetes()
    {
        return $this->hasMany(Paquete::class);
    }
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}
