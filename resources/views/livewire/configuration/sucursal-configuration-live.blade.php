<div class="p-4 bg-white rounded-lg shadow-md">
    <form wire:submit.prevent="save" class="space-y-4">
        <x-mary-select label="SUCURSAL DESTINO" icon="o-user" :options="$sucursales" wire:model.live="sucursal_destino_id"
            placeholder="NO SELECT" placeholder-value="0" />
        <x-mary-select label="TRANSPORTISTA" icon="o-user" :options="$transportistas" wire:model.live="transportista_id"
            placeholder="NO SELECT" placeholder-value="0" />
        <x-mary-select label="VEHICULO" icon="o-user" :options="$vehiculos" wire:model.live="vehiculo_id"
            placeholder="NO SELECT" placeholder-value="0" />
        <x-mary-button type="submit" class="w-full">Save</x-mary-button>
    </form>

    @php
    $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'destino', 'label' => 'DESTINO'],
        ['key' => 'transportista', 'label' => 'TRANSPORTISTA'],
        ['key' => 'vehiculo', 'label' => 'VEHICULO'],
    ];
    @endphp

    <x-mary-table :headers="$headers" :rows="$configurations" striped class="mt-6">
        @scope('cell_destino', $config)
        <x-mary-badge :value="$config->destino->name" class="badge-primary" />
        @endscope
        @scope('cell_transportista', $config)
        <x-mary-badge :value="$config->transportista->name" class="badge-primary" />
        @endscope
        @scope('cell_vehiculo', $config)
        <x-mary-badge :value="$config->vehiculo->name" class="badge-primary" />
        @endscope
    </x-mary-table>
</div>