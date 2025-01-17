<?php

namespace App\Models\Facturacion;

use App\Models\Configuration\Company;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'encomienda_id',
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
        'xml_path',
        'xml_hash',
        'cdr_description',
        'cdr_code',
        'cdr_note',
        'cdr_path', 
        'monto_letras',
        'setPercent',
        'setMount',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function encomienda()
    {
        return $this->belongsTo(Encomienda::class);
    }
    public function client()
    {
        return $this->belongsTo(Customer::class);
    }
    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
