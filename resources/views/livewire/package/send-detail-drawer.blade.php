@isset($encomienda)
    <x-mary-drawer wire:model="showDrawer" title="Detalle de encomienda" subtitle="Code {{ $encomienda->code }}"
        separator with-close-button close-on-escape class="w-11/12 lg:w-2/3" right>
        <x-mary-card shadow>
            <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="REMITENTE" />
            <div class="grid grid-cols-5 grid-rows-3 gap-1 bg-green-200 rounded">
                <div class="col-span-3">{{ $encomienda->remitente->name ?? 'name' }}</div>
                <div class="row-start-2">{{ strtoupper($encomienda->remitente->type_code) ?? 'type_code' }}
                </div>
                <div class="row-start-2">{{ $encomienda->remitente->code ?? 'code' }}</div>
                <div class="row-start-2">{{ $encomienda->remitente->phone ?? 'phone' }}</div>
                <div class="col-span-3">{{ $encomienda->sucursal_remitente->name ?? 'sucursal' }}</div>
            </div>
            <x-mary-icon name="s-envelope" class="text-red-500 text-md" label="DESTINATARIO" />
            <div class="grid grid-cols-5 grid-rows-3 gap-1 bg-red-100 rounded">
                <div class="col-span-3">{{ $encomienda->destinatario->name ?? 'name' }}</div>
                <div class="row-start-2">{{ strtoupper($encomienda->destinatario->type_code) ??
                    'type_code' }}</div>
                <div class="row-start-2">{{ $encomienda->destinatario->code ?? 'code' }}</div>
                <div class="row-start-2">{{ $encomienda->destinatario->phone ?? 'phone' }}</div>
                <div class="col-span-3">{{ $encomienda->sucursal_destino->name ?? 'sucursal' }}</div>
            </div>
            <x-mary-icon name="s-envelope" class="text-sky-500 text-md" label="DETALLE PAQUETES" />
            @php
            $headers_paquets = [
            ['key' => 'cantidad', 'label' => 'Cantidad', 'class' => ''],
            ['key' => 'description', 'label' => 'Descripción', 'class' => ''],
            ['key' => 'peso', 'label' => 'Peso', 'class' => ''],
            ['key' => 'amount', 'label' => 'P.UNIT', 'class' => ''],
            ['key' => 'sub_total', 'label' => 'MONTO', 'class' => ''],
            ];
            @endphp
            <x-mary-table :headers="$headers_paquets" :rows="$encomienda->paquetes" striped>
            </x-mary-table>
        </x-mary-card>
    </x-mary-drawer>
@endisset