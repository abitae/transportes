<?php

namespace App\Models\Facturacion;

use App\Models\Configuration\Company;
use App\Models\Package\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipoDoc',
        'tipoOperacion',
        'serie',
        'correlativo',
        'fechaEmision',
        'formaPago_moneda',
        'formaPago_tipo',
        'tipoMoneda',
        'company_id',
        'client_id',
        'mtoOperGravadas',
        'mtoIGV',
        'totalImpuestos',
        'valorVenta',
        'subTotal',
        'mtoImpVenta',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function client()
    {
        return $this->belongsTo(Customer::class);
    }
}
