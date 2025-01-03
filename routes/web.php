<?php

use App\Http\Controllers\pdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController;
use App\Livewire\Caja\CajaLive;
use App\Livewire\Componentes;
use App\Livewire\Configuration\CompanyLive;
use App\Livewire\Configuration\RoleLive;
use App\Livewire\Configuration\SucursalLive;
use App\Livewire\Configuration\TransportistaLive;
use App\Livewire\Configuration\UserLive;
use App\Livewire\Configuration\VehiculoLive;
use App\Livewire\Facturacion\DespatcheLive;
use App\Livewire\Facturacion\InvoiceLive;
use App\Livewire\Facturacion\TicketLive;
use App\Livewire\Frontend\MessageLive;
use App\Livewire\Home\DashboardLive;
use App\Livewire\Package\CustomerLive;
use App\Livewire\Package\DeliverPackageLive;
use App\Livewire\Package\HomePackageLive;
use App\Livewire\Package\ReceivePackageLive;
use App\Livewire\Package\RecordPackageLive;
use App\Livewire\Package\RegisterLive;
use App\Livewire\Package\SendPackageLive;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteController::class, 'index'])->name('index');
Route::get('/nosotros', [WebsiteController::class, 'abount'])->name('abount');
Route::get('/servicios', [WebsiteController::class, 'servicios'])->name('servicios');
Route::get('/contacto', [WebsiteController::class, 'contact'])->name('contacto');
Route::get('/tracking', [WebsiteController::class, 'tracking'])->name('tracking');
Route::post('/tracking', [WebsiteController::class, 'trackingSearch'])->name('tracking.search');

Route::post('/contactoform', [WebsiteController::class, 'contactForm'])->name('contacto.form');




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
    Route::get('/company', CompanyLive::class)->name('config.company');
});
Route::middleware('auth')->group(function () {
    Route::get('/customer', CustomerLive::class)->name('package.customer');
    Route::get('/registrar', RegisterLive::class)->name('package.register');
    Route::get('/send_package', SendPackageLive::class)->name('package.send');
    Route::get('/receive_package', ReceivePackageLive::class)->name('package.receive');
    Route::get('/deliver_package', DeliverPackageLive::class)->name('package.deliver');
    Route::get('/record_package', RecordPackageLive::class)->name('package.record');
    Route::get('/home_package', HomePackageLive::class)->name('package.home');
});

Route::middleware('auth')->group(function () {
    Route::get('/message', MessageLive::class)->name('message.frontend');
});


Route::middleware('auth')->group(function () {
    Route::get('/ticket', TicketLive::class)->name('facturacion.ticket');
    Route::get('/invoice', InvoiceLive::class)->name('facturacion.invoice');
    Route::get('/despache', DespatcheLive::class)->name('facturacion.despache');
});

Route::get('/ticket/80mm/{ticket}', [pdfController::class, 'ticket80mm']);
Route::get('/ticket/a4/{ticket}', [pdfController::class, 'ticketA4']);

Route::get('/invoice/80mm/{invoice}', [pdfController::class, 'invoice80mm']);
Route::get('/invoice/a4/{invoice}', [pdfController::class, 'invoiceA4']);

Route::get('/despache/80mm/{despache}', [pdfController::class, 'despache80mm']);
Route::get('/despache/a4/{despache}', [pdfController::class, 'despacheA4']);

Route::get('/sticker/a5/{encomienda}', [pdfController::class, 'stickerA5']);

require __DIR__ . '/auth.php';
