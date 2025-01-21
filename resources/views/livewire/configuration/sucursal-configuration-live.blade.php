<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-mary-form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-3 grid-rows-1 gap-1">
                <x-mary-select label="SUCURSAL DESTINO" icon="o-user" :options="$sucursales"
                    wire:model.live="sucursal_destino_id" placeholder="NO SELECT" placeholder-value="0" />
                <x-mary-select label="TRANSPORTISTA" icon="o-user" :options="$transportistas"
                    wire:model.live="transportista_id" placeholder="NO SELECT" placeholder-value="0" />
                <x-mary-select label="VEHICULO" icon="o-user" :options="$vehiculos" wire:model.live="vehiculo_id"
                    placeholder="NO SELECT" placeholder-value="0" />
            </div>
            <x-slot:actions>
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
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
        <p>{{ $config->destino->name }}</p> 
        @endscope
        @scope('cell_transportista', $config)
        <x-mary-badge :value="$config->transportista->name" class="badge-primary" />
        @endscope
        @scope('cell_vehiculo', $config)
        <x-mary-badge :value="$config->vehiculo->name" class="badge-primary" />
        @endscope
    </x-mary-table>
</div>