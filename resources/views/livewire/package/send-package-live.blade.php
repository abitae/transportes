<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo envio"
                class="text-white bg-sky-500" />
        </x-slot:menu>
        @php
        $users = App\Models\User::take(5)->get();
        @endphp
        <div class="grid grid-cols-6 gap-1 shadow-xl">
            <div class="grid col-span-1">
                <x-mary-select label="Destino" icon="s-inbox-stack" :options="$sucursals" wire:model="sucursal_dest_id"
                    inline />
            </div>
            <div class="grid col-span-1">
                <x-mary-datetime label="Desde" wire:model="date_ini" icon="o-calendar" inline />
            </div>
            <div class="grid col-span-1">
                <x-mary-datetime label="Hasta" wire:model="date_fin" icon="o-calendar" inline />
            </div>
            <div class="grid col-span-2">

            </div>
            <div class="grid col-span-1">
                <x-mary-button wire:click='openModal' responsive icon="s-truck" label="Enviar paquetes"
                    class="text-white bg-green-500" />
            </div>
        </div>
        <x-mary-menu-separator />
        <div class="grid grid-cols-4 gap-1 shadow-xl">
            <div class="grid col-span-4">
                <x-mary-card shadow separator>
                    @php
                    $headers = [
                    ['key' => 'actions', 'label' => 'Action', 'class' => ''],
                    ['key' => 'code', 'label' => 'Codigo', 'class' => ''],
                    ['key' => 'remitente', 'label' => 'Remitente', 'class' => ''],
                    ['key' => 'destinatario', 'label' => 'Destinatario', 'class' => ''],
                    ];
                    $row_decoration = [
                    'bg-red-50' => fn(App\Models\package\Encomienda $encomienda) => !$encomienda->isActive,
                    ];
                    @endphp
                    <x-mary-table wire:model="selected" selectable :headers="$headers" :rows="$encomiendas"
                        with-pagination per-page="perPage" :row-decoration="$row_decoration"
                        :per-page-values="[10, 50, 100, 150]">
                        <x-slot:empty>
                            <x-mary-icon name="o-cube" label="No se encontro registros." />
                        </x-slot:empty>
                        @scope('cell_code', $stuff)
                        <nobr>
                            <x-mary-badge :value="strtoupper($stuff->code)" class="badge-warning" />
                        </nobr>
                        @endscope
                        @scope('cell_remitente', $stuff)

                        <div class="grid grid-cols-5 grid-rows-5 gap-1">
                            <div class="col-span-3">
                                <x-mary-badge :value="$stuff->remitente->code" class="bg-purple-500 text-white" />
                            </div>
                            <div class="col-span-4 row-start-2">
                                <x-mary-badge :value="strtoupper($stuff->remitente->name)"
                                    class="w-full badge-info text-white text-right" />

                            </div>
                            <div class="col-span-2 row-start-3">
                                <x-mary-badge :value="$stuff->sucursal_remitente->name"
                                    class="bg-green-500 text-white" />
                            </div>
                            <div class="col-span-2 col-start-3 row-start-3">
                                <x-mary-badge :value="$stuff->sucursal_remitente->created_at->format('d/m/Y')"
                                    class="badge-warning text-white text-right" />
                            </div>
                            <div class="col-span-4 row-start-4">
                                <x-mary-badge :value="$stuff->sucursal_remitente->address"
                                    class="w-full bg-pink-200 text-white text-right" />
                            </div>
                        </div>

                        @endscope
                        @scope('cell_destinatario', $stuff)
                        <div class="grid grid-cols-5 grid-rows-5 gap-1">
                            <div class="col-span-3">
                                <x-mary-badge :value="$stuff->destinatario->code" class="bg-purple-500 text-white" />
                            </div>
                            <div class="col-span-4 row-start-2">
                                <x-mary-badge :value="strtoupper($stuff->destinatario->name)"
                                    class="w-full badge-info text-white text-right" />

                            </div>
                            <div class="col-span-2 row-start-3">
                                <x-mary-badge :value="$stuff->sucursal_destinatario->name"
                                    class="bg-green-500 text-white" />
                            </div>
                            <div class="col-span-2 col-start-3 row-start-3">
                                <x-mary-badge :value="$stuff->sucursal_destinatario->created_at->format('d/m/Y')"
                                    class="badge-warning text-white text-right" />
                            </div>
                            <div class="col-span-4 row-start-4">
                                <x-mary-badge :value="$stuff->sucursal_destinatario->address"
                                    class="w-full bg-pink-200 text-white text-right" />
                            </div>
                        </div>
                        @endscope

                        @scope('cell_actions', $user)
                        <nobr>
                            <x-mary-button icon="o-no-symbol" wire:click="delete({{ $user->id }})" spinner
                                class="btn-xs bg-red-500 text-white" />
                            <x-mary-button icon="o-pencil-square" wire:click="delete({{ $user->id }})" spinner
                                class="btn-xs bg-yellow-500 text-white" />
                            <x-mary-button icon="s-bars-3" wire:click="delete({{ $user->id }})" spinner
                                class="btn-xs bg-cyan-500 text-white" />
                            <x-mary-button icon="o-printer" wire:click="delete({{ $user->id }})" spinner
                                class="btn-xs bg-purple-500 text-white" />
                        </nobr>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>

    </x-mary-card>
    <x-mary-modal wire:model="modalCustomer" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md"
            label="{{ !isset($customerForm->user) ? 'CREAR CLIENTE' : 'EDITAR CLIENTE' }}" />
        <x-mary-form wire:submit.prevent="{{ !isset($customerForm->customer) ? 'create' : 'update' }}">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input wire:model.live='customerForm.code' label="Numero documento" inline>
                            <x-slot:prepend>
                                @php
                                $docs = [
                                ['id' => 'dni', 'name' => 'DNI'],
                                ['id' => 'ruc', 'name' => 'RUC'],
                                ['id' => 'ce', 'name' => 'CE'],
                                ];
                                @endphp
                                <x-mary-select wire:model='customerForm.type_code' icon="o-user" :options="$docs"
                                    class="bg-purple-300 rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button icon="o-magnifying-glass"
                                    class="bg-purple-300 btn-secondary rounded-s-none" wire:click='SearchDocument'
                                    spinner='SearchDocument' />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Denominacion" inline wire:model='customerForm.name' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Email" inline wire:model='customerForm.email' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Telefono" inline wire:model='customerForm.phone' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Direccion" inline wire:model='customerForm.address' />
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