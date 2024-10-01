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
                    ];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$encomiendas"
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
                            <x-mary-button icon="s-bars-3" wire:click="openModal({{ $stuff->id }})" spinner
                                class="text-white btn-xs bg-cyan-500" />
                            <x-mary-button icon="o-printer" wire:click="delete({{ $stuff->id }})" spinner
                                class="text-white bg-purple-500 btn-xs" />
                        </nobr>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>

    </x-mary-card>
    <x-mary-modal wire:model="modalDeliver" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md"
            label="ENTREGAR ENCOMIENDA" />
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
</div>