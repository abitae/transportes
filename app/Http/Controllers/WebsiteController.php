<?php

namespace App\Http\Controllers;

use App\Models\Configuration\Sucursal;
use App\Models\Frontend\Message;
use App\Models\Package\Encomienda;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::where('isActive', 1)->get();

        return view('web.index', compact('sucursales'));
    }
    public function rastrea()
    {
        return view('web.rastrea');
    }
    public function abount()
    {
        return view('web.nosotros');
    }
    public function contact()
    {
        return view('web.contact');
    }
    public function terminos()
    {
        return view('web.terminos');
    }
    public function trackingSearch(Request $request){
        $request->validate(
            [
                'tracking' => 'required',
                'code' => 'required',
            ]);
        $encomienda = Encomienda::where('code', $request->tracking)
            ->whereHas('remitente', function($query) use ($request) {
                $query->where('code', $request->code);
            })
            ->orWhereHas('destinatario', function($query) use ($request) {
                $query->where('code', $request->code); 
            })
            ->first();  
            
        if($encomienda){
            return view('web.rastrea', compact('encomienda'));
        }else{
            return view('web.rastrea');
        }
    }
    public function contactForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'select' => 'required',
            'message' => 'required',
        ]);
        Message::create($validated);
        return view('web2.contact');
    }
    public function servicios()
    {
        return view('web.services');
    }

}
