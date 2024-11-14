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
            <x-mary-button label="Messages" icon="o-envelope" link="###" class="btn-ghost btn-sm" responsive />
            <x-mary-button icon="o-bell" class="relative btn-circle">
                <x-mary-badge value="2" class="absolute badge-error -right-2 -top-2" />
            </x-mary-button>
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="o-user" class="relative btn-circle" responsive no-wire-navigate />
                </x-slot:trigger>
                <x-mary-menu-item icon="o-user" title="Perfil" :href="route('profile.edit')"/>
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
                    <x-mary-menu-item title="Paquetes entregados" icon="o-arrow-path"
                        link="{{ route('package.record') }}" />
                    <x-mary-menu-item title="Clientes" icon="o-user-group" link="{{ route('package.customer') }}" />
                </x-mary-menu-sub>
                <x-mary-menu-separator />
                <x-mary-menu-sub title="Facturacion" icon="s-banknotes">
                    <x-mary-menu-item title="Facturas" icon="o-ticket" link="{{ route('facturacion.invoice') }}" />
                    <x-mary-menu-item title="Ticket" icon="c-ticket" link="{{ route('facturacion.ticket') }}" />
                    <x-mary-menu-item title="Guias" icon="s-ticket" link="{{ route('config.role') }}" />
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
                <x-mary-menu-item title="Messages" icon="o-envelope" link="###" />
            </x-mary-menu>
        </x-slot:sidebar>
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>
    <x-mary-toast />
    <x-mary-spotlight />
</body>

</html>