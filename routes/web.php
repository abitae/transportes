<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Caja\CajaLive;
use App\Livewire\Componentes;
use App\Livewire\Configuration\RoleLive;
use App\Livewire\Configuration\SucursalLive;
use App\Livewire\Configuration\UserLive;
use App\Livewire\Package\CustomerLive;
use App\Livewire\Package\DeliverPackageLive;
use App\Livewire\Package\ReceivePackageLive;
use App\Livewire\Package\RegisterLive;
use App\Livewire\Package\SendLive;
use App\Livewire\Package\SendPackageLive;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/user', UserLive::class)->name('config.user');
    Route::get('/role', RoleLive::class)->name('config.role');
});
Route::middleware('auth')->group(function () {
    Route::get('/customer', CustomerLive::class)->name('package.customer');
    Route::get('/registrar', RegisterLive::class)->name('package.register');
    Route::get('/send_package', SendPackageLive::class)->name('package.send');
    Route::get('/receive_package', ReceivePackageLive::class)->name('package.receive');
    Route::get('/deliver_package', DeliverPackageLive::class)->name('package.deliver');
});
require __DIR__ . '/auth.php';
