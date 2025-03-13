<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryCaja extends Model
{
    use HasFactory;
    protected $fillable = [
        'caja_id',
        'monto_entry',
        'description',
        'tipo_pago',
        'tipo',
    ];
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
