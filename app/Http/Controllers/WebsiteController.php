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

        return view('web2.index', compact('sucursales'));
    }

    public function abount()
    {
        return view('web2.nosotros');
    }
    public function contact()
    {
        return view('web2.contact');
    }
    public function tracking()
    {
        return view('web2.trackin');
    }
    public function trackingSearch(Request $request){
        $request->validate(
            [
                'tracking' => 'required',
                'code' => 'required',
            ]);
        $encomienda = Encomienda::where('code', $request->tracking)->where('pin', $request->code)->first();
        if($encomienda){
            return view('web2.trackin', compact('encomienda'));
        }else{
            return view('web2.trackin');
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
