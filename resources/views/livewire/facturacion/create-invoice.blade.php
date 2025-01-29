<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="img/logo01.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- It will not apply locale yet --}}
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        flatpickr.localize(flatpickr.l10ns.es);
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    <x-mary-nav sticky full-width>
        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <img src="{{ asset('img/logo01.png') }}" alt='Infinity.ut' class='w-auto h-10'>

        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            <x-mary-icon name="s-home" class="text-xl text-center text-green-500 w-9 h-9"
                label="{{ auth()->user()->sucursal->name }}" />
            <x-mary-theme-toggle darkTheme="dark" lightTheme="light" />
            <x-mary-button label="Messages" icon="o-envelope" link="/message" class="btn-ghost btn-sm" responsive />
            <x-mary-button icon="o-bell" class="relative btn-circle" link="/message">
                @php
                $messages = App\Models\Frontend\Message::where('isActive', true)->get()->count();
                @endphp
                <x-mary-badge value="{{ $messages }}" class="absolute badge-error -right-2 -top-2" />

            </x-mary-button>
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="o-user" class="relative btn-circle" responsive no-wire-navigate />
                </x-slot:trigger>
                <x-mary-menu-item icon="o-user" title="Perfil" :href="route('profile.edit')" />
                @if ($user = auth()->user())
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-mary-menu-item icon="o-power" title="Cerrar" :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();" />
                </form>
                @endif
            </x-mary-dropdown>
        </x-slot:actions>
    </x-mary-nav>
    <x-mary-main with-nav full-width>
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">
            <x-mary-menu activate-by-route>
                <x-mary-menu-item title="Caja" icon="o-banknotes" link="{{ route('caja.index') }}" />
                <x-mary-menu-item title="Configuracion sucursal" icon="o-banknotes" link="{{ route('config.configuration') }}" />
                <x-mary-menu-separator />
                <x-mary-menu-sub title="Paquetes" icon="s-truck">
                    <x-mary-menu-item title="Registrar paquetes" icon="o-cursor-arrow-rays"
                        link="{{ route('package.register') }}" />
                    <x-mary-menu-item title="Enviar paquetes" icon="c-arrow-up-tray"
                        link="{{ route('package.send') }}" />
                    <x-mary-menu-item title="Recibir paquetes" icon="c-arrow-down-tray"
                        link="{{ route('package.receive') }}" />
                    <x-mary-menu-item title="Entregar paquetes" icon="o-cursor-arrow-ripple"
                        link="{{ route('package.deliver') }}" />
                    <x-mary-menu-item title="Paquetes domicilio" icon="o-cursor-arrow-ripple"
                        link="{{ route('package.home') }}" />
                        <x-mary-menu-item title="Paquetes retorno" icon="o-cursor-arrow-ripple"
                        link="{{ route('package.return') }}" />
                    <x-mary-menu-item title="Paquetes entregados" icon="o-arrow-path"
                        link="{{ route('package.record') }}" />
                    <x-mary-menu-item title="Clientes" icon="o-user-group" link="{{ route('package.customer') }}" />
                    <x-mary-menu-item title="Manifiesto" icon="o-user-group" link="{{ route('package.maniesto') }}" />
                </x-mary-menu-sub>
                <x-mary-menu-separator />
                <x-mary-menu-sub title="Facturacion" icon="s-banknotes">
                    <x-mary-menu-item title="Facturas" icon="o-ticket" link="{{ route('facturacion.invoice') }}" />
                    <x-mary-menu-item title="Ticket" icon="c-ticket" link="{{ route('facturacion.ticket') }}" />
                    <x-mary-menu-item title="Guias" icon="s-ticket" link="{{ route('facturacion.despache') }}" />
                </x-mary-menu-sub>
                <x-mary-menu-separator />
                <x-mary-menu-sub title="Configuracion" icon="o-cog-6-tooth">
                    <x-mary-menu-item title="Company" icon="o-home" link="{{ route('config.company') }}" />
                    <x-mary-menu-item title="Sucursales" icon="o-home-modern" link="{{ route('config.sucursal') }}" />
                    <x-mary-menu-item title="Usuarios" icon="o-user" link="{{ route('config.user') }}" />
                    <x-mary-menu-item title="Roles" icon="o-users" link="{{ route('config.role') }}" />
                    <x-mary-menu-item title="Vehiculos" icon="m-truck" link="{{ route('config.vehiculo') }}" />
                    <x-mary-menu-item title="Choferes" icon="o-user-circle"
                        link="{{ route('config.transportista') }}" />
                </x-mary-menu-sub>

                <x-mary-menu-separator />
                <x-mary-menu-item title="Messages" icon="o-envelope" link="{{ route('message.frontend') }}" />
            </x-mary-menu>
        </x-slot:sidebar>
        <x-slot:content>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>Crear Factura</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $company = 'Empresa de Prueba';
                            $tipoDoc = '01';
                            $serie = 'F001';
                            $correlativo = '0001';
                            $monto = '100.00';
                            $detalle = 'Detalle de prueba';
                            $items = [
                                ['descripcion' => 'Producto 1', 'cantidad' => 1, 'precio_unitario' => 50.00],
                                ['descripcion' => 'Producto 2', 'cantidad' => 1, 'precio_unitario' => 50.00],
                            ];
                        @endphp
                        <form wire:submit.prevent="createInvoice">
                            <div class="form-group">
                                <label for="company">Empresa</label>
                                <x-mary-input type="text" id="company" wire:model="company" class="form-control" value="{{ $company }}"></x-mary-input>
                                @error('company') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="tipoDoc">Tipo de Documento</label>
                                <x-mary-input type="text" id="tipoDoc" wire:model="tipoDoc" class="form-control" value="{{ $tipoDoc }}"></x-mary-input>
                                @error('tipoDoc') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="serie">Serie</label>
                                <x-mary-input type="text" id="serie" wire:model="serie" class="form-control" value="{{ $serie }}"></x-mary-input>
                                @error('serie') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="correlativo">Correlativo</label>
                                <x-mary-input type="text" id="correlativo" wire:model="correlativo" class="form-control" value="{{ $correlativo }}"></x-mary-input>
                                @error('correlativo') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="monto">Monto</label>
                                <x-mary-input type="text" id="monto" wire:model="monto" class="form-control" value="{{ $monto }}"></x-mary-input>
                                @error('monto') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="detalle">Detalle</label>
                                <x-mary-textarea id="detalle" wire:model="detalle" class="form-control">{{ $detalle }}</x-mary-textarea>
                                @error('detalle') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="items">Ítems de Venta</label>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $index => $item)
                                        <tr>
                                            <td><x-mary-input type="text" wire:model="items.{{ $index }}.descripcion" class="form-control" value="{{ $item['descripcion'] }}"></x-mary-input></td>
                                            <td><x-mary-input type="number" wire:model="items.{{ $index }}.cantidad" class="form-control" value="{{ $item['cantidad'] }}"></x-mary-input></td>
                                            <td><x-mary-input type="number" wire:model="items.{{ $index }}.precio_unitario" class="form-control" value="{{ $item['precio_unitario'] }}"></x-mary-input></td>
                                            <td>{{ $item['cantidad'] * $item['precio_unitario'] }}</td>
                                            <td><x-mary-button type="button" wire:click="removeItem({{ $index }})" class="btn btn-danger">Eliminar</x-mary-button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <x-mary-button type="button" wire:click="addItem" class="btn btn-secondary">Agregar Ítem</x-mary-button>
                            </div>
                            <x-mary-button type="submit" class="btn btn-primary">Crear Factura</x-mary-button>
                        </form>
                    </div>
                </div>
            </div>
        </x-slot:content>
    </x-mary-main>
    <x-mary-toast />
    <x-mary-spotlight />
</body>

</html>



