<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-input label="Buscar envio" inline wire:model.live='search' />
        </x-slot:menu>
        <div class="grid grid-cols-6 gap-1 shadow-xl">
            <div class="grid col-span-2">
                <x-mary-select label="Raiz" icon="s-inbox-stack" :options="$sucursals" wire:model.live="sucursal_id"
                    inline />
            </div>
            <div class="grid col-span-2">
                <x-mary-datetime label="Fecha" wire:model.live="date_ini" icon="o-calendar" inline />
            </div>
        </div>
        <x-mary-menu-separator />
        <div class="grid grid-cols-4 gap-1 shadow-xl">
            <div class="grid col-span-4">
                <x-mary-card shadow separator>
                    @php
                    $headers = [
                    ['key' => 'actions', 'label' => 'Action', 'class' => ''],
                    ['key' => 'estado', 'label' => 'Estado', 'class' => ''],
                    ['key' => 'remitente', 'label' => 'Remitente', 'class' => ''],
                    ['key' => 'destinatario', 'label' => 'Destinatario', 'class' => ''],
                    ];
                    $row_decoration = [
                    'bg-red-50' => fn(App\Models\package\Encomienda $encomienda) => !$encomienda->isActive,];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$encomiendas" with-pagination per-page="perPage"
                        :row-decoration="$row_decoration" :per-page-values="[100, 150, 200]">
                        <x-slot:empty>
                            <x-mary-icon name="o-cube" label="No se encontro registros." />
                        </x-slot:empty>
                        @scope('cell_estado', $stuff)
                        <x-mary-badge :value="strtoupper('Pagado')"
                            class="w-min-full {{ $stuff->estado_pago == 'CONTRA ENTREGA' ? 'bg-red-500': 'bg-green-500' }}" />
                        <br>
                        <x-mary-badge :value="strtoupper('Domicilio')"
                            class="w-min-full {{ !$stuff->isHome ? 'bg-red-500': 'bg-green-500' }}" />
                        <br>
                        <x-mary-badge :value="strtoupper('Retorno')"
                            class="w-min-full {{ !$stuff->isReturn ? 'bg-red-500': 'bg-green-500' }}" />
                        @endscope
                        @scope('cell_remitente', $stuff)
                        <div class="grid grid-cols-1 grid-rows-4 gap-1 text-xs">
                            <div>
                                <x-mary-badge :value="$stuff->remitente->code" class="text-white bg-purple-500" />
                            </div>
                            <div>
                                {{ strtoupper($stuff->remitente->name) }}
                            </div>
                            <div>
                                <x-mary-badge :value="$stuff->sucursal_remitente->name"
                                    class="text-xs text-white bg-green-500" />
                            </div>
                            <div>
                                <x-mary-badge :value="$stuff->sucursal_remitente->created_at->format('d/m/Y')"
                                    class="text-xs text-right text-white badge-warning" />
                            </div>
                            <div>
                                {{ $stuff->sucursal_remitente->address }}
                            </div>
                        </div>
                        @endscope
                        @scope('cell_destinatario', $stuff)
                        <div class="grid grid-cols-1 grid-rows-4 gap-1 text-xs">
                            <div>
                                <x-mary-badge :value="$stuff->destinatario->code" class="text-white bg-purple-500" />
                            </div>
                            <div>
                                {{ strtoupper($stuff->destinatario->name)}}
                            </div>
                            <div>
                                <x-mary-badge :value="$stuff->sucursal_destinatario->name"
                                    class="text-xs text-white bg-green-500" />
                            </div>
                            <div>
                                <x-mary-badge :value="$stuff->sucursal_destinatario->created_at->format('d/m/Y')"
                                    class="text-xs text-right text-white badge-warning" />
                            </div>
                            <div>
                                @if ($stuff->isHome)
                                REPARTO DOMICILIO
                                <br>
                                {{ $stuff->destinatario->address }}
                                @else
                                ENTREGA SUCURSAL
                                <br>
                                {{ $stuff->sucursal_destinatario->address }}
                                @endif
                            </div>
                        </div>
                        @endscope
                        @scope('cell_actions', $stuff)
                        <div class="grid grid-cols-2 grid-rows-5 gap-0">
                            <div class="col-span-2">
                                <x-mary-badge :value="strtoupper($stuff->code)"
                                    class="w-full text-white text-xs {{ $stuff->estado_pago == 'CONTRA ENTREGA' ? 'bg-red-500': 'bg-green-500' }}" />
                            </div>
                            <div class="row-start-2">
                                <x-mary-button label='Detalle' icon="s-bars-3"
                                    wire:click="detailEncomienda({{ $stuff->id }})" spinner
                                    class="w-full text-white btn-xs bg-cyan-500" />
                            </div>
                            <div class="row-start-2">
                                @if ($stuff->invoice)
                                <x-mary-button label='Recibo' icon="o-printer" target="_blank" no-wire-navigate
                                    link="/invoice/80mm/{{ $stuff->invoice->id }}" spinner
                                    class="w-full text-white bg-purple-500 btn-xs" />
                                @endif
                            </div>
                            <div class="row-start-3">
                               
                                
                            </div>
                            <div class="row-start-3">
                                @if ($stuff->ticket)
                                <x-mary-button label='Ticket' icon="o-printer" target="_blank" no-wire-navigate
                                    link="/ticket/80mm/{{ $stuff->ticket->id }}" spinner
                                    class="w-full text-white bg-cyan-500 btn-xs" />
                                @endif
                            </div>
                            <div class="row-start-4">
                               
                            </div>
                            <div class="row-start-4">
                                <x-mary-button label='Guia T' icon="o-printer" target="_blank" no-wire-navigate
                                    link="/despache/80mm/{{ $stuff->despatche->id }}" spinner
                                    class="w-full text-white bg-green-500 btn-xs" />
                            </div>
                            <div class="row-start-5">
                                <x-mary-badge :value="strtoupper($stuff->estado_pago)"
                                    class="w-full text-white text-xs {{ $stuff->estado_pago == 'CONTRA ENTREGA' ? 'bg-red-500': 'bg-green-500' }}" />
                            </div>
                            <div class="row-start-4">

                            </div>
                        </div>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
    @isset($encomienda)
    <x-mary-modal wire:model="modalDeliver" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="ENTREGAR ENCOMIENDA" />
        <x-mary-form wire:submit.prevent="deliverPaquetes">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Numero documento" inline wire:model='document' />
                    </div>
                    @if (!$this->encomienda->isHome)
                    <div class="grid col-span-4 pt-2">
                        <x-mary-icon name="o-hashtag" label="PING" />
                        <x-mary-pin ida='pin01' wire:model="pin" size="3" numeric />
                    </div>
                    @endif
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancel" @click="$wire.modalDeliver = false" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="deliverPaquetes" label="Save" class="bg-blue-500" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
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
            ['key' => 'description', 'label' => 'Descripcion', 'class' => ''],
            ['key' => 'peso', 'label' => 'Peso', 'class' => ''],
            ['key' => 'amount', 'label' => 'P.UNIT', 'class' => ''],
            ['key' => 'sub_total', 'label' => 'MONTO', 'class' => ''],
            ];
            @endphp
            <x-mary-table :headers="$headers_paquets" :rows="$encomienda->paquetes" striped>
            </x-mary-table>
        </x-mary-card>
    </x-mary-drawer>
    <x-mary-modal wire:model="modalConfimation" persistent class="backdrop-blur"
        box-class="max-w-full max-h-full bg-purple-50">
        <div class="grid grid-cols-8 gap-2 p-2 border roundedlg border-sky-500">
            <div class="grid col-span-4">
                <div class="grid grid-cols-8 border rounded-lg border-sky-500">
                    <div class="grid col-span-8">
                        <x-mary-card shadow>
                            <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="REMITENTE" />
                            <div class="grid grid-cols-5 grid-rows-3 gap-1 bg-green-200 rounded">
                                <div class="col-span-3">{{ $encomienda->remitente->name ?? 'name' }}
                                </div>
                                <div class="row-start-2">{{
                                    strtoupper($encomienda->remitente->type_code) ?? 'type_code'
                                    }}
                                </div>
                                <div class="row-start-2">{{ $encomienda->remitente->code ?? 'code' }}
                                </div>
                                <div class="row-start-2">{{ $encomienda->remitente->phone ?? 'phone' }}
                                </div>
                                <div class="col-span-3">{{ $encomienda->sucursal_remitente->name ??
                                    'sucursal' }}</div>
                            </div>
                            <x-mary-icon name="s-envelope" class="text-red-500 text-md" label="DESTINATARIO" />
                            <div class="grid grid-cols-5 grid-rows-3 gap-1 bg-red-100 rounded">
                                <div class="col-span-3">{{ $encomienda->destinatario->name ?? 'name' }}
                                </div>
                                <div class="row-start-2">{{
                                    strtoupper($encomienda->destinatario->type_code) ??
                                    'type_code' }}</div>
                                <div class="row-start-2">{{ $encomienda->destinatario->code ?? 'code' }}
                                </div>
                                <div class="row-start-2">{{ $encomienda->destinatario->phone ?? 'phone'
                                    }}</div>
                                <div class="col-span-3">{{ $encomienda->sucursal_destino->name ??
                                    'sucursal' }}</div>
                            </div>
                            <x-mary-icon name="s-envelope" class="text-sky-500 text-md" label="DETALLE PAQUETES" />
                            <x-mary-table :headers="$headers_paquets" :rows="$encomienda->paquetes" striped>
                            </x-mary-table>
                        </x-mary-card>
                    </div>
                </div>
            </div>
            @php
            $pagos = [
            ['id' => 'PAGADO', 'name' => 'PAGADO'],
            ['id' => 'CONTRA ENTREGA', 'name' => 'CONTRA ENTREGA'],
            ];
            $comprobantes = [
            ['id' => 'BOLETA', 'name' => 'BOLETA'],
            ['id' => 'FACTURA', 'name' => 'FACTURA'],
            ['id' => 'TICKET', 'name' => 'TICKET'],
            ];
            $docs = [
            ['id' => 'dni', 'name' => 'DNI'],
            ['id' => 'ruc', 'name' => 'RUC'],
            ['id' => 'ce', 'name' => 'CE'],
            ];
            @endphp
            <div class="grid col-span-4 space-x-2">
                <div class="grid grid-cols-8 border rounded-lg border-sky-500">
                    <div class="grid col-span-8 space-y-2">
                        <x-mary-card shadow>
                            <x-mary-icon name="s-envelope" class="text-blue-500 text-md" label="DETALLE PAGO" />
                            <x-mary-radio class="w-full max-w-full py-0 text-xs" :options="$pagos" option-value="id"
                                option-label="name" wire:model.live="estado_pago" disabled />
                            @if ($estado_pago=='CONTRA ENTREGA')
                            <x-mary-icon name="s-envelope" class="text-red-500 text-md" label="TIPO COMPROBANTE" />
                            <x-mary-radio class="w-full max-w-full py-0 text-xs" :options="$comprobantes"
                                option-value="id" option-label="name" wire:model.live="tipo_comprobante" />
                            @if ($tipo_comprobante!='TICKET')
                            <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="DETALLE COMPROBANTE" />
                            <div class="grid grid-cols-4 gap-2 p-2 border rounded-lg border-sky-500">
                                <div class="grid col-span-4 pt-2">
                                    <x-mary-input label="Numero de documento" wire:model.live='customerFact.code'>
                                        <x-slot:prepend>
                                            @php
                                            if ($tipo_comprobante!='FACTURA') {
                                            $docsfact = [
                                            ['id' => 'dni', 'name' => 'DNI'],
                                            ['id' => 'ruc', 'name' => 'RUC'],
                                            ];
                                            }else {
                                            $docsfact = [
                                            ['id' => 'ruc', 'name' => 'RUC'],
                                            ];
                                            }
                                            @endphp
                                            <x-mary-select wire:model.live='customerFact.type_code' icon="o-user"
                                                :options="$docsfact" class="rounded-e-none" />
                                        </x-slot:prepend>
                                        <x-slot:append>
                                            <x-mary-button wire:click='searchFacturacion' icon="o-magnifying-glass"
                                                class="btn-primary rounded-s-none" />
                                        </x-slot:append>
                                    </x-mary-input>
                                </div>
                                <div class="grid col-span-2 pt-2">
                                    <x-mary-input label="Nombre/Raz. Social" wire:model.live='customerFact.name'>
                                    </x-mary-input>
                                </div>
                                <div class="grid col-span-2 pt-2">
                                    <x-mary-input label="Direccion" wire:model.live='customerFact.address'>
                                    </x-mary-input>
                                </div>
                            </div>
                            @endif
                            @endif
                        </x-mary-card>
                    </div>
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.modalConfimation = false" />
                <x-mary-button wire:click='confirmEncomienda' label="Confirm" class="btn-primary" />
            </x-slot:actions>
        </div>
    </x-mary-modal>
    @endisset
</div>