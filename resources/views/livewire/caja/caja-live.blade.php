<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" shadow separator progress-indicator>
        <x-slot:menu>
            <x-mary-button wire:click="openModal" icon="s-eye{{ !$openCaja ? '' : '-slash' }}"
                label="{{ !$openCaja ? 'Abrir' : 'Cerrar' }} Caja" class="text-white bg-sky-500" responsive />
            <x-mary-button @click="$wire.showHistory = true" icon="s-eye" label="Historial"
                class="text-white bg-purple-500" responsive />
        </x-slot:menu>
        @if ($openCaja)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
            <div>
                <x-mary-stat title="Monto apertura" description="Apertura" value="{{ $caja->monto_apertura }}"
                    icon="o-arrow-trending-up" tooltip="Ops!" />
            </div>
            <div>
                <x-mary-stat title="Ingresos" description="Boletas, Facturas y ticket"
                    value="{{ $caja->entries->sum('monto_entry') }}" icon="o-arrow-trending-up" class="text-green-500"
                    color="text-green-500" tooltip="Total entradas de dinero" />
            </div>
            <div>
                <x-mary-stat title="Egresos" description="Pagos y salidas" value="{{ $caja->exits->sum('monto_exit') }}"
                    icon="o-arrow-trending-down" class="text-red-500" color="text-red-500"
                    tooltip="Total salidas de dinero" />
            </div>
            <div>
                <x-mary-stat title="Monto cierre" description="Cierre"
                    value="{{ $caja->monto_apertura + $caja->entries->sum('monto_entry') - $caja->exits->sum('monto_exit') }}"
                    icon="o-arrow-trending-down" tooltip="Ops!" />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div>
                <x-mary-card title="Ingresos" subtitle="Registro de ingresos a caja" shadow separator>
                    <x-slot:menu>
                        <x-mary-button @click="$wire.modalEntry = true" responsive icon="o-plus" label="Ingreso"
                            class="text-white bg-green-500" />
                    </x-slot:menu>
                    <x-mary-table :headers="$headersIngreso" :rows="$caja->entries" striped>
                    </x-mary-table>
                </x-mary-card>
            </div>
            <div>
                <x-mary-card title="Egresos" subtitle="Registro de egresos de caja" shadow separator>
                    <x-slot:menu>
                        <x-mary-button @click="$wire.modalExit = true" responsive icon="c-minus" label="Egreso"
                            class="text-white bg-red-500" />
                    </x-slot:menu>
                    <x-mary-table :headers="$headersEgreso" :rows="$caja->exits" striped>
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
        @endif
    </x-mary-card>

    @include('livewire.caja.caja-modal')

    <x-mary-drawer wire:model="showHistory" class="w-11/12 lg:w-2/3" right>
        <div>
            @isset($cajas)
            @php
            $row_decoration = [
            'bg-yellow-500' => fn(App\Models\Caja\Caja $caja) => $caja->isActive,
            ];
            @endphp
            <x-mary-table :headers="$headersHistory" :rows="$cajas" striped :row-decoration="$row_decoration"
                with-pagination per-page="perPage" :per-page-values="[5, 20, 10, 50]">
                @scope('cell_created_at', $stuff)
                <x-mary-badge :value="$stuff->created_at->format('d/m/Y')" class="badge-info" />
                @endscope
                @scope('cell_updated_at', $stuff)
                <x-mary-badge :value="$stuff->updated_at->format('d/m/Y')" class="badge-warning" />
                @endscope
                @scope('cell_action', $stuff)
                @if (!$stuff->isActive)
                <x-mary-button icon="o-printer" wire:click="printCaja({{ $stuff->id }})" spinner
                    class="text-white bg-purple-500 btn-xs" />
                @endif
                @endscope
            </x-mary-table>
            @else
            <p>No tiene historial.</p>
            @endisset
        </div>
    </x-mary-drawer>
</div>
