<x-mary-main with-nav full-width>
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">
        <x-mary-menu activate-by-route>
            <x-mary-menu-separator />
            <x-mary-menu-item title="Dashboard" icon="o-rectangle-group" link="{{ route('dashboard') }}" />
            <x-mary-menu-separator />
            <x-mary-menu-item title="Caja" icon="o-banknotes" link="{{ route('caja.index') }}" />
            <x-mary-menu-item title="Salidas" icon="s-paper-airplane" link="{{ route('config.configuration') }}" />
            <x-mary-menu-separator />
            <x-mary-menu-sub title="Paquetes" icon="s-truck">
                <x-mary-menu-item title="Registrar paquetes" icon="o-cursor-arrow-rays"
                    link="{{ route('package.register') }}" />
                <x-mary-menu-item title="Enviar paquetes" icon="c-arrow-up-tray" link="{{ route('package.send') }}" />
                <x-mary-menu-item title="Recibir paquetes" icon="c-arrow-down-tray"
                    link="{{ route('package.receive') }}" />
                <x-mary-menu-item title="Entregar paquetes" icon="o-cursor-arrow-ripple"
                    link="{{ route('package.deliver') }}" />
                <x-mary-menu-item title="Paquetes domicilio" icon="o-cursor-arrow-ripple"
                    link="{{ route('package.home') }}" />
                <x-mary-menu-item title="Paquetes retorno" icon="o-cursor-arrow-ripple"
                    link="{{ route('package.return') }}" />
                <x-mary-menu-item title="Paquetes entregados" icon="m-table-cells"
                    link="{{ route('package.record') }}" />
                <x-mary-menu-item title="Clientes" icon="o-user-group" link="{{ route('package.customer') }}" />
                <x-mary-menu-item title="Manifiesto" icon="s-inbox-arrow-down" link="{{ route('package.maniesto') }}" />
            </x-mary-menu-sub>
            <x-mary-menu-separator />
            <x-mary-menu-sub title="Facturacion" icon="s-banknotes">
                <x-mary-menu-item title="Emitir Factura" icon="o-ticket"
                    link="{{ route('facturacion.create-invoice') }}" />
                <x-mary-menu-item title="Emitir Boleta" icon="o-ticket"
                    link="{{ route('facturacion.create-invoice') }}" />
                <x-mary-menu-item title="Emitir Nota Credito" icon="o-ticket"
                    link="{{ route('facturacion.create-note') }}" />

                <x-mary-menu-item title="Ver Boletas y facturas" icon="c-ticket"
                    link="{{ route('facturacion.invoice') }}" />
                <x-mary-menu-item title="Ver Ticket Envio" icon="c-ticket" link="{{ route('facturacion.ticket') }}" />
                <x-mary-menu-item title="Ver Guias Transportista" icon="s-ticket"
                    link="{{ route('facturacion.despache') }}" />
                <x-mary-menu-item title="Ver Notas Credito" icon="s-ticket" link="{{ route('facturacion.note') }}" />
            </x-mary-menu-sub>
            <x-mary-menu-separator />
            <x-mary-menu-sub title="Configuracion" icon="o-cog-6-tooth">
                <x-mary-menu-item title="Company" icon="o-home" link="{{ route('config.company') }}" />
                <x-mary-menu-item title="Sucursales" icon="o-home-modern" link="{{ route('config.sucursal') }}" />
                <x-mary-menu-item title="Usuarios" icon="o-user" link="{{ route('config.user') }}" />
                <x-mary-menu-item title="Roles" icon="o-users" link="{{ route('config.role') }}" />
                <x-mary-menu-item title="Vehiculos" icon="m-truck" link="{{ route('config.vehiculo') }}" />
                <x-mary-menu-item title="Choferes" icon="o-user-circle" link="{{ route('config.transportista') }}" />
            </x-mary-menu-sub>
            <x-mary-menu-separator />
            <x-mary-menu-item title="Messages" icon="o-envelope" link="{{ route('message.frontend') }}" />
            <x-mary-menu-item title="Reclamaciones" icon="o-envelope" link="{{ route('message.frontend') }}" />
            <x-mary-menu-item title="Cotizaciones" icon="o-envelope" link="{{ route('message.frontend') }}" />
            <x-mary-menu-separator />
        </x-mary-menu>
    </x-slot:sidebar>
    <x-slot:content>
        {{ $slot }}
    </x-slot:content>
</x-mary-main>