<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            @php
                $tipes = [
                    ['id' => 'Y', 'name' => 'Año'],
                    ['id' => 'm', 'name' => 'Mes'],
                    ['id' => 'd', 'name' => 'Dia'],
                ];
            @endphp
            <x-mary-select label="Tipo vista" wire:model.live="selectedTipe" 
            :options="$tipes" class="w-full sm:w-auto" />
        </x-slot:menu>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-4">
            <div class="border border-cyan-500 rounded-lg shadow-xl p-4 h-full">
                <x-mary-icon name="o-presentation-chart-line" class="w-9 h-9 text-green-500 text-2xl"
                    label="Monto recaudado por sucursal" />
                <div>
                    <x-mary-chart wire:model="myLine" />
                </div>
            </div>
            <div class="border border-cyan-500 rounded-lg shadow-xl p-4 h-full">
                <x-mary-icon name="o-chart-pie" class="w-9 h-9 text-green-500 text-2xl" label="Encomiendas" />
                <div class="chart-container" style="position: relative; height:6vh; width:12vw">
                    <x-mary-chart wire:model="myPie" />
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="border border-cyan-500 rounded-lg shadow-xl p-4 h-full">
                <x-mary-icon name="o-chart-bar" class="w-9 h-9 text-green-500 text-2xl"
                    label="Encomiendas por sucursal" />
                <div>
                    <x-mary-chart wire:model="myBar" />
                </div>
            </div>
            <div class="border border-cyan-500 rounded-lg shadow-xl p-4 h-full">
                <x-mary-icon name="o-presentation-chart-line" class="w-9 h-9 text-green-500 text-2xl"
                    label="Monto recaudado por sucursal" />
                <div>
                    
                </div>
            </div>
        </div>
    </x-mary-card>
</div>