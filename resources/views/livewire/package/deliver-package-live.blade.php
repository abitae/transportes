<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-input label="Buscar envio" inline wire:model.live='search' />
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo envio"
                class="text-white bg-sky-500" />
        </x-slot:menu>
        <div class="grid grid-cols-6 gap-1 shadow-xl">
            <div class="grid col-span-1">
                <x-mary-select label="Raiz" icon="s-inbox-stack" :options="$sucursals" wire:model="sucursal_id"
                    inline />
            </div>
            <div class="grid col-span-1">
                <x-mary-datetime label="Fecha" wire:model.live="date_ini" icon="o-calendar" inline />
            </div>
            <div class="grid col-span-2">

            </div>
            <div class="grid col-span-1">

            </div>
        </div>
        <x-mary-menu-separator />
        <div class="grid grid-cols-4 gap-1 shadow-xl">
            <div class="grid col-span-4">
                <x-mary-card shadow separator>
                    @php
                    $headers = [
                    ['key' => 'actions', 'label' => 'Action', 'class' => ''],
                    ['key' => 'remitente', 'label' => 'Remitente', 'class' => ''],
                    ['key' => 'destinatario', 'label' => 'Destinatario', 'class' => ''],
                    ];
                    $row_decoration = [
                    'bg-red-50' => fn(App\Models\package\Encomienda $encomienda) => !$encomienda->isActive,
                    'bg-blue-400' => fn(App\Models\package\Encomienda $encomienda) => $encomienda->estado_pago == 2,
                    ];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$encomiendas" with-pagination per-page="perPage"
                        :row-decoration="$row_decoration" :per-page-values="[100, 150, 200]">
                        <x-slot:empty>
                            <x-mary-icon name="o-cube" label="No se encontro registros." />
                        </x-slot:empty>
                        @scope('cell_remitente', $stuff)
                        <div class="grid grid-cols-5 grid-rows-5 gap-1">
                            <div class="col-span-3">
                                <x-mary-badge :value="$stuff->remitente->code" class="text-white bg-purple-500" />
                            </div>
                            <div class="col-span-4 row-start-2">
                                {{ strtoupper($stuff->remitente->name) }}
                            </div>
                            <div class="col-span-2 row-start-3">
                                <x-mary-badge :value="$stuff->sucursal_remitente->name"
                                    class="text-white bg-green-500" />
                            </div>
                            <div class="col-span-2 col-start-3 row-start-3">
                                <x-mary-badge :value="$stuff->sucursal_remitente->created_at->format('d/m/Y')"
                                    class="text-right text-white badge-warning" />
                            </div>
                            <div class="col-span-4 row-start-4">
                                {{ $stuff->sucursal_remitente->address }}
                            </div>
                        </div>
                        @endscope
                        @scope('cell_destinatario', $stuff)
                        <div class="grid grid-cols-5 grid-rows-5 gap-1">
                            <div class="col-span-3">
                                <x-mary-badge :value="$stuff->destinatario->code" class="text-white bg-purple-500" />
                            </div>
                            <div class="col-span-4 row-start-2">
                                {{ strtoupper($stuff->destinatario->name)}}

                            </div>
                            <div class="col-span-2 row-start-3">
                                <x-mary-badge :value="$stuff->sucursal_destinatario->name"
                                    class="text-white bg-green-500" />
                            </div>
                            <div class="col-span-2 col-start-3 row-start-3">
                                <x-mary-badge :value="$stuff->sucursal_destinatario->created_at->format('d/m/Y')"
                                    class="text-right text-white badge-warning" />
                            </div>
                            <div class="col-span-4 row-start-4">
                                {{ $stuff->sucursal_destinatario->address }}
                            </div>
                        </div>
                        @endscope

                        @scope('cell_actions', $stuff)
                        <x-mary-badge :value="strtoupper($stuff->code)" class="w-min-full badge-warning" />
                        <br>
                        <nobr>
                            <x-mary-button icon="o-pencil-square" wire:click="openModal({{ $stuff->id }})" spinner
                                class="text-white bg-yellow-500 btn-xs" />
                            <x-mary-button icon="s-bars-3" wire:click="detailEncomienda({{ $stuff->id }})" spinner
                                class="text-white btn-xs bg-cyan-500" />
                            <x-mary-button icon="o-printer" wire:click="printEncomienda({{ $stuff->id }})" spinner
                                class="text-white bg-purple-500 btn-xs" />
                        </nobr>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>

    </x-mary-card>
    <x-mary-modal wire:model="modalDeliver" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="ENTREGAR ENCOMIENDA" />
        <x-mary-form wire:submit.prevent="deliverPaquetes">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">

                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Numero documento" inline wire:model='document' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-icon name="o-hashtag" label="PING" />
                        <x-mary-pin wire:model="pin" size="3" numeric />
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancel" wire:click="openModal()" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="{{ !isset($customerForm->sucursal) ? 'create' : 'edit' }}"
                        label="Save" class="bg-blue-500" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
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
                                <div class="col-span-3">{{ $encomienda->remitente->name ?? 'name' }}</div>
                                <div class="row-start-2">{{ strtoupper($encomienda->remitente->type_code) ?? 'type_code'
                                    }}
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

                            <x-mary-table :headers="$headers_paquets" :rows="$encomienda->paquetes" striped>
                            </x-mary-table>
                        </x-mary-card>

                    </div>
                </div>
            </div>
            @php
            $pagos = [
            ['id' => 1, 'name' => 'PAGADO'],
            ['id' => 2, 'name' => 'CONTRA ENTREGA'],
            ];
            $comprobantes = [
            ['id' => 1, 'name' => 'BOLETA'],
            ['id' => 2, 'name' => 'FACTURA'],
            ['id' => 3, 'name' => 'TICKET'],
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

                            @if ($estado_pago==2)
                            <x-mary-icon name="s-envelope" class="text-red-500 text-md" label="TIPO COMPROBANTE" />
                            <x-mary-radio class="w-full max-w-full py-0 text-xs" :options="$comprobantes"
                                option-value="id" option-label="name" wire:model.live="tipo_comprobante" />
                            @if ($tipo_comprobante!=3)
                            <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="DETALLE COMPROBANTE" />
                            <div class="grid grid-cols-4 gap-2 p-2 border rounded-lg border-sky-500">
                                <div class="grid col-span-4 pt-2">
                                    <x-mary-input label="Numero de documento" wire:model.live='customerFact.code'>
                                        <x-slot:prepend>
                                            <x-mary-select wire:model.live='customerFact.type_code' icon="o-user"
                                                :options="$docs" class="rounded-e-none" />
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