<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController;
use App\Livewire\Caja\CajaLive;
use App\Livewire\Componentes;
use App\Livewire\Configuration\RoleLive;
use App\Livewire\Configuration\SucursalLive;
use App\Livewire\Configuration\TransportistaLive;
use App\Livewire\Configuration\UserLive;
use App\Livewire\Configuration\VehiculoLive;
use App\Livewire\Home\DashboardLive;
use App\Livewire\Package\CustomerLive;
use App\Livewire\Package\DeliverPackageLive;
use App\Livewire\Package\ReceivePackageLive;
use App\Livewire\Package\RecordPackageLive;
use App\Livewire\Package\RegisterLive;
use App\Livewire\Package\SendPackageLive;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteController::class, 'index'])->name('index');
Route::get('/servicios', [WebsiteController::class, 'servicios'])->name('servicios');
Route::get('/contacto', [WebsiteController::class, 'contact'])->name('contacto');
Route::get('/rotulo', [WebsiteController::class, 'rotulo'])->name('rotulo');
Route::get('/search-tracking', [WebsiteController::class, 'trancking'])->name('search-tracking');

Route::post('subscribe-newsletter', 'WebsiteController@subscribeNewsletter');
Route::get('/libro-de-reclamaciones', "LibroDeReclamacionController@complaintsBook")->name('libro-de-reclamaciones');
Route::get("/lista-sucursales", "LibroDeReclamacionController@getListBranchOffices");
Route::post("/registrar-reclamacion", "LibroDeReclamacionController@registerClaim");
Route::get('/cotizacion/{view}', "CotizacionController@quotation")->name('cotizacion');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardLive::class)->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/componentes', Componentes::class)->name('componentes');
    Route::get('/caja', CajaLive::class)->name('caja.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/sucursal', SucursalLive::class)->name('config.sucursal');
    Route::get('/vehiculo', VehiculoLive::class)->name('config.vehiculo');
    Route::get('/transportistas', TransportistaLive::class)->name('config.transportista');
    Route::get('/user', UserLive::class)->name('config.user');
    Route::get('/role', RoleLive::class)->name('config.role');
});
Route::middleware('auth')->group(function () {
    Route::get('/customer', CustomerLive::class)->name('package.customer');
    Route::get('/registrar', RegisterLive::class)->name('package.register');
    Route::get('/send_package', SendPackageLive::class)->name('package.send');
    Route::get('/receive_package', ReceivePackageLive::class)->name('package.receive');
    Route::get('/deliver_package', DeliverPackageLive::class)->name('package.deliver');
    Route::get('/record_package', RecordPackageLive::class)->name('package.record');
});
require __DIR__ . '/auth.php';
