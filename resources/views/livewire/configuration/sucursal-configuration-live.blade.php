<div>
    <form wire:submit="save">
        <x-mary-select label="SUCURSAL DESTINO" icon="o-user" :options="$sucursales" wire:model="sucursal_destino_id"
            placeholder="NO SELECT" placeholder-value="0" />
        <x-mary-select label="TRANSPORTISTA" icon="o-user" :options="$trasnportistas" wire:model="transportista_id"
            placeholder="NO SELECT" placeholder-value="0" />
        <x-mary-select label="VEHICULO" icon="o-user" :options="$vehiculos" wire:model="vehiculo_id"
            placeholder="NO SELECT" placeholder-value="0" />
        <button type="submit">Save</button>
    </form>
    @php

    $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'destino', 'label' => 'DESTINO'],
        ['key' => 'transportista', 'label' => 'TRANSPORTISTA'],
        ['key' => 'vehiculo', 'label' => 'VEHICULO'],
    ];
    @endphp
    
    <x-mary-table :headers="$headers" :rows="$configurations" striped>
        @scope('cell_destino', $config)
        <x-mary-badge :value="$config->destino->name" class="badge-primary" />
        @endscope
        @scope('cell_transportista', $config)
        <x-mary-badge :value="$config->transportista->name" class="badge-primary" />
        @endscope
        @scope('cell_vehiculo', $config)
        <x-mary-badge :value="$config->transportista->name" class="badge-primary" />
        @endscope
    </x-mary-table>
</div>