<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-input label="Buscar envio" inline wire:model.live='search' />
            <x-mary-button wire:click='openModal' responsive icon="s-truck" label="Enviar paquetes"
                class="text-white bg-green-500" />
        </x-slot:menu>
        <div class="grid grid-cols-6 gap-2 p-2 shadow-md">
            <div class="grid col-span-2">
                <x-mary-select label="Destino" icon="s-inbox-stack" :options="$sucursals" wire:model="sucursal_dest_id"
                    inline />
            </div>
            <div class="grid col-span-2">
                <x-mary-datetime label="Fecha de registro" wire:model.live="date_ini" icon="o-calendar" inline />
            </div>
            <div class="grid col-span-2">
                <x-mary-toggle label="Activos" wire:model.live="isActive" class="toggle-danger" right tight />
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
                    'bg-red-400' => fn(App\Models\package\Encomienda $encomienda) => !$encomienda->isActive,
                    ];
                    @endphp
                    <x-mary-table wire:model="selected" selectable :headers="$headers" :rows="$encomiendas"
                        with-pagination per-page="perPage" :row-decoration="$row_decoration"
                        :per-page-values="[100, 150, 200]">
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
                            <x-mary-button icon="o-no-symbol" wire:click="enableEncomienda({{ $stuff->id }})" spinner
                                wire:confirm.prompt="Esta seguro?\n\nEscriba {{ $stuff->remitente->code }} para confirmar|{{$stuff->remitente->code}}"
                                class="text-white bg-red-500 btn-xs" />
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
    <x-mary-modal wire:model="modalEnvio" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="ENVIAR PAQUETES" />
        <x-mary-form wire:submit.prevent="sendPaquetes">
            <div class="p-2 border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 gap-1">
                    <div class="grid col-span-4">
                        <x-mary-card title="{{ $this->numElementos ?? 0 }}" subtitle="Paquetes selecionados" shadow
                            separator>
                            Sucursal de destino : {{ $this->sucursal_dest->name ?? 'Sucursal destino' }}
                        </x-mary-card>
                        <div class="grid col-span-4">
                            <x-mary-datetime label="Fecha y hora de traslado" wire:model.live="date_traslado"
                                icon="o-calendar" type="datetime-local" />
                        </div>
                        <div class="grid col-span-4">
                            <x-mary-choices-offline label="Transportista" wire:model="transportista_id"
                                :options="$transportistas" single searchable />
                        </div>
                        <div class="grid col-span-4">
                            <x-mary-choices-offline label="Vehiculos" wire:model="vehiculo_id" :options="$vehiculos"
                                single searchable />
                        </div>
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancel" wire:click="openModal()" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="sendPaquetes" label="Save" class="bg-blue-500" />
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
    @endisset


</div>