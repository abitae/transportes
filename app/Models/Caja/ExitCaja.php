<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitCaja extends Model
{
    use HasFactory;
    protected $fillable = [
        'caja_id',
        'monto_exit',
        'description',
        'tipo',
    ];
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
