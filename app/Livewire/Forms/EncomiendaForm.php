<?php

namespace App\Livewire\Forms;

use App\Models\Package\Encomienda;
use App\Models\Package\Paquete;
use App\Traits\LogCustom;
use Livewire\Form;

class EncomiendaForm extends Form
{
    use LogCustom;

    public $code;
    public $user_id;
    public $transportista_id;
    public $vehiculo_id;

    public $customer_id;
    public $sucursal_id;

    public $customer_dest_id;
    public $sucursal_dest_id;
    public $customer_fact_id;
    public $cantidad;
    public $monto;
    public $estado_pago;
    public $tipo_pago;
    public $tipo_comprobante;
    public $doc_traslado;
    public $glosa;
    public $observation;
    public $estado_encomienda;
    public $pin;
    public $isReturn;
    public $isHome;
    public function store($paquetes)
    {
        try {
            $paquetesKey = collect([]);
            $encomienda = Encomienda::create([
                'code' => $this->code,
                'user_id' => $this->user_id,
                'transportista_id' => $this->transportista_id,
                'vehiculo_id' => $this->vehiculo_id,
                'customer_id' => $this->customer_id,
                'sucursal_id' => $this->sucursal_id,
                'customer_dest_id' => $this->customer_dest_id,
                'sucursal_dest_id' => $this->sucursal_dest_id,
                'customer_fact_id' => $this->customer_fact_id,
                'cantidad' => $this->cantidad,
                'monto' => $this->monto,
                'estado_pago' => $this->estado_pago,
                'tipo_pago' => $this->tipo_pago,
                'tipo_comprobante' => $this->tipo_comprobante,
                'doc_traslado' => $this->doc_traslado,
                'glosa' => $this->glosa,
                'observation' => $this->observation,
                'estado_encomienda' => $this->estado_encomienda,
                'pin' => $this->pin,
                'isReturn' => $this->isReturn,
                'isHome' => $this->isHome,
            ]);

            foreach ($paquetes as $paquete) {
                
                Paquete::create([
                    'cantidad' => $paquete['cantidad'],
                    'und_medida' => $paquete['und_medida'],
                    'description' => $paquete['description'],
                    'peso' => $paquete['peso'],
                    'amount' => $paquete['amount'],
                    'sub_total' => $paquete['sub_total'],
                    'encomienda_id' => $encomienda->id,
                ]);
            }
            //dump($paquetes);
            $this->infoLog('Encomienda store' . $encomienda->id);
            return $encomienda;
        } catch (\Exception $e) {
            $this->errorLog('Encomienda store', $e);
            return null;
        }

    }
}
