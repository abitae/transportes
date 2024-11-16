<?php

namespace App\Http\Controllers;

use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::where('isActive', 1)->get();

        return view('web2.index', compact('sucursales'));
    }

    public function contact()
    {
        return view('web.contact');
    }

    public function servicios()
    {
        return view('web.services');
    }
    public function trancking(Request $request)
    {
        $codeTracking = $request->codeTracking;
        $recipientDni = $request->recipientDni;
        $shipment = Encomienda::with('remitente')->where('code', $codeTracking)->where('isActive', 1)->first();
        //dump($encomienda);
        //$shipment = Shipment::with(['sucursal', 'sucursal_destino', 'detalle_envio'])->where('id_generado', $codeTracking)->where('documento_destinatario', $recipientDni)->first();
        if (!$shipment) {
            return back();
        }

        return view('web.tracking', compact('shipment'));
    }
}
