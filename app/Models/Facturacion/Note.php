<?php
namespace App\Models\Facturacion;

use App\Models\Configuration\Company;
use App\Models\Package\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
            'company_id',
            'customer_id',
            'ublVersion',
            'tipoDoc',
            'serie',
            'correlativo',
            'fechaEmision',
            'tipoDocAfectado',
            'numDocfectado',
            'codMotivo',
            'desMotivo',
            'tipoMoneda',
            'mtoOperGravadas',
            'mtoIGV',
            'totalImpuestos',
            'mtoImpVenta',
            'monto_letras',
            'legends',
            'xml_path',
            'xml_hash',
            'cdr_description',
            'cdr_code',
            'cdr_note',
            'cdr_path',
            'errorCode',
            'errorMessage',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function client()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    /**
     * Relación con los detalles de la factura.
     */
    public function details()
    {
        return $this->hasMany(NoteDetail::class);
    }
}
