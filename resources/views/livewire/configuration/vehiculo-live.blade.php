<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo vehiculo"
                class="text-white bg-sky-500" />
        </x-slot:menu>
        <div class="grid content-start grid-cols-4 xs:grid-cols-1">
            <x-mary-stat title="Paquetes" description="Paquetes pendientes de envio" value="44" icon="m-archive-box"
                tooltip="Paquetes" />
            <x-mary-stat title="Monto apertura" description="This month" value="12" icon="o-arrow-trending-up"
                tooltip="Ops!" />
            <x-mary-stat title="Ingresos" description="Boletas, Facturas y ticket" value="12" icon="o-arrow-trending-up"
                class="text-green-500" color="text-green-500" tooltip="Total entradas de dinero" />
            <x-mary-stat title="Egresos" description="Pagos y salidas" value="123" icon="o-arrow-trending-down"
                class="text-red-500" color="text-red-500" tooltip="Total salidas de dinero" />
        </div>
    </x-mary-card>
    <div class="grid grid-cols-4 space-x-2">
        <div class="grid col-span-4 pt-2">
            <x-mary-card shadow separator>
                @php
                $headers = [
                ['key' => 'id', 'label' => '#', 'class' => 'bg-blue-500 w-1'],
                ['key' => 'name', 'label' => 'Name', 'class' => ''],
                ['key' => 'marca', 'label' => 'Marca', 'class' => ''],
                ['key' => 'modelo', 'label' => 'Modelo', 'class' => ''],
                ['key' => 'tipo', 'label' => 'Tipo', 'class' => ''],
                ['key' => 'isActive', 'label' => 'isActive', 'class' => ''],
                ];
                $row_decoration = [
                'bg-red-50' => fn(App\Models\Configuration\Vehiculo $vehiculo) => !$vehiculo->isActive,
                ];
                @endphp
                <x-mary-table :headers="$headers" :rows="$vehiculos" with-pagination per-page="perPage"
                    :row-decoration="$row_decoration" :per-page-values="[5, 20, 10, 50]">
                    @scope('cell_isActive', $stuff)
                    <button wire:click='estado({{ $stuff->id }})'
                        wire:confirm.prompt="Estas seguro de eliminar registro?\n\nEscriba 'SI' para confirmar!|SI"
                        class="flex items-center">
                        <div
                            class="h-2.5 w-2.5 rounded-full {{ $stuff->isActive ? 'bg-green-400' : 'bg-red-600' }} mr-2">
                        </div>
                        {{ $stuff->isActive ? 'Active' : 'Disabled' }}
                    </button>
                    @endscope
                    @scope('actions', $vehiculo)
                    <nobr>
                        <x-mary-button icon="s-pencil-square" wire:click="update({{ $vehiculo->id }})" spinner
                            class="btn-sm" />
                        <x-mary-button icon="o-trash" wire:click="delete({{ $vehiculo->id }})"
                            wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                            class="btn-sm" />
                    </nobr>
                    @endscope
                </x-mary-table>
            </x-mary-card>
        </div>
    </div>
    <x-mary-modal wire:model="modalVehiculo" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md"
            label="{{ !isset($vehiculoForm->vehiculo) ? 'CREAR VEHICULO' : 'EDITAR VEHICULO' }}" />
        <x-mary-form wire:submit="{{ !isset($vehiculoForm->vehiculo) ? 'create' : 'edit' }}">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Nombre" inline wire:model='vehiculoForm.name' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Direccion" inline wire:model='vehiculoForm.marca' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Telefono" inline wire:model='vehiculoForm.modelo' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        @php
                        $tipos = [
                        ['id'=> 'INTERNO' , 'name' => 'INTERNO'],
                        ['id'=> 'EXTERNO', 'name' => 'EXTERNO'],
                        ]
                        @endphp
                        <x-mary-select label="Tipo" icon="o-user" :options="$tipos" wire:model='vehiculoForm.tipo'
                            inline />
                    </div>

                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancel" @click="$wire.modalVehiculo = false" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="{{ !isset($vehiculoForm->vehiculo) ? 'create' : 'edit' }}"
                        label="Save" class="bg-blue-500" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
</div>