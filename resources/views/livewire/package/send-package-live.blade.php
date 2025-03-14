<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-input label="Buscar envio" inline wire:model.live='search' />
            <x-mary-button wire:click='openModal' responsive icon="s-truck" label="Enviar paquetes"
                class="text-white bg-green-500" />
        </x-slot:menu>
        <div class="grid grid-cols-6 gap-2 p-2 shadow-md">
            <div class="grid col-span-2">
                <x-mary-select label="Destino" icon="s-inbox-stack" :options="$sucursals"
                    wire:model.live="sucursal_dest_id" inline />
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
                            ['key' => 'actions', 'label' => 'Acción', 'class' => ''],
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
                            <x-mary-icon name="o-cube" label="No se encontraron registros." />
                        </x-slot:empty>
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
                        <div class="grid grid-cols-2 gap-0">
                            <div class="col-span-2">
                                <x-mary-badge :value="strtoupper($stuff->code)"
                                    class="w-full h-full text-white text-xl {{ $stuff->estado_pago == 'CONTRA ENTREGA' ? 'bg-red-500' : 'bg-green-500' }}" />
                            </div>
                            <div>
                                <x-mary-button label='Detalle' icon="s-bars-3"
                                    wire:click="detailEncomienda({{ $stuff->id }})" spinner
                                    class="w-full h-full text-white btn-xs bg-cyan-500" />
                            </div>
                            <div>
                                @if ($stuff->invoice)
                                    <x-mary-button label='Recibo' icon="o-printer" target="_blank" no-wire-navigate
                                        link="/invoice/80mm/{{ $stuff->invoice->id }}" spinner
                                        class="w-full h-full text-white bg-purple-500 btn-xs" />
                                @endif
                            </div>
                            <div>
                                <x-mary-button label='Editar' icon="o-pencil-square"
                                    wire:click="editEncomienda({{ $stuff->id }})" spinner
                                    class="w-full h-full text-white bg-green-500 btn-xs" />

                            </div>
                            <div>
                                @if ($stuff->ticket)
                                    <x-mary-button label='Ticket' icon="o-printer" target="_blank" no-wire-navigate
                                        link="/ticket/80mm/{{ $stuff->ticket->id }}" spinner
                                        class="w-full h-full text-white bg-cyan-500 btn-xs" />
                                @endif
                            </div>
                            <div>
                                <x-mary-button label='Anular' icon="o-no-symbol"
                                    wire:click="enableEncomienda({{ $stuff->id }})" spinner
                                    wire:confirm.prompt="Esta seguro?\n\nEscriba {{ $stuff->remitente->code }} para confirmar|{{$stuff->remitente->code}}"
                                    class="w-full h-full text-white bg-red-500 btn-xs" />

                            </div>
                            <div>
                                @if ($stuff->despatche)
                                    <x-mary-button label='Guia T' icon="o-printer" target="_blank" no-wire-navigate
                                        link="/despache/80mm/{{ $stuff->despatche->id }}" spinner
                                        class="w-full h-full text-white bg-green-500 btn-xs" />
                                @endif
                            </div>
                            <div>
                                <x-mary-badge :value="strtoupper($stuff->estado_pago)"
                                    class="w-full h-full text-white text-xs {{ $stuff->estado_pago == 'CONTRA ENTREGA' ? 'bg-red-500' : 'bg-green-500' }}" />
                            </div>
                            <div>
                                @if ($stuff->despatche)
                                    <x-mary-button label='Sticker' icon="o-printer" target="_blank" no-wire-navigate
                                        link="/sticker/a6/{{ $stuff->despatche->id }}" spinner
                                        class="w-full h-full text-white bg-blue-500 btn-xs" />
                                @endif
                            </div>
                        </div>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
    @include('livewire.package.send-modal')
    @include('livewire.package.send-detail-drawer')
    @include('livewire.package.send-edit-modal')
    @include('livewire.package.send-manifiesto-modal')
</div>