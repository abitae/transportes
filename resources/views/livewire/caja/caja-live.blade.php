<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            <x-mary-button wire:click="openModal" icon="s-eye{{ !$openCaja ? '' : '-slash' }}"
                label="{{ !$openCaja ? 'Abrir' : 'Cerrar' }} Caja" class="text-white bg-sky-500" responsive />
            <x-mary-button @click="$wire.showHistory = true" icon="s-eye" label="Historial"
                class="text-white bg-purple-500" responsive />
        </x-slot:menu>
        @if ($openCaja)
        <div class="grid content-start grid-cols-4 xs:grid-cols-1">
            <x-mary-stat title="Monto apertura" description="Apertura" value="{{ $caja->monto_apertura }}"
                icon="o-arrow-trending-up" tooltip="Ops!" />
            <x-mary-stat title="Ingresos" description="Boletas, Facturas y ticket"
                value="{{ $caja->entries->sum('monto_entry') }}" icon="o-arrow-trending-up" class="text-green-500"
                color="text-green-500" tooltip="Total entradas de dinero" />
            <x-mary-stat title="Egresos" description="Pagos y salidas" value="{{ $caja->exits->sum('monto_exit') }}"
                icon="o-arrow-trending-down" class="text-red-500" color="text-red-500"
                tooltip="Total salidas de dinero" />
            <x-mary-stat title="Monto cierre" description="Cierre"
                value="{{ $caja->monto_apertura + $caja->entries->sum('monto_entry') - $caja->exits->sum('monto_exit') }}"
                icon="o-arrow-trending-down" tooltip="Ops!" />
        </div>
        @endif
    </x-mary-card>

    @if ($openCaja)
    <div class="grid grid-cols-4 space-x-2">
        <div class="grid col-span-2 pt-2">
            <x-mary-card title="Ingresos" subtitle="Registro de ingresos a caja" shadow separator>
                <x-slot:menu>
                    <x-mary-button @click="$wire.modalEntry = true" responsive icon="o-plus" label="Ingreso"
                        class="text-white bg-green-500" />
                </x-slot:menu>
                <x-mary-table :headers="$headersIngreso" :rows="$caja->entries" striped>
                </x-mary-table>
            </x-mary-card>
        </div>
        <div class="grid col-span-2 pt-2">
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

    <x-mary-modal wire:model="modalCaja" persistent class="backdrop-blur" box-class="max-h-full max-w-128">
        <x-mary-icon name="s-envelope" class="text-{{ !$openCaja ? 'green' : 'red' }}-500 text-md"
            label="{{ !$openCaja ? 'ABRIR' : 'CERRAR' }} CAJA" />
        <x-mary-form wire:submit="save">
            <div class="border border-{{ !$openCaja ? 'green' : 'red' }}-500 rounded-lg">
                <div class="grid grid-cols-4 p-2 space-x-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Monto {{ !$openCaja ? 'apertura' : 'cierre' }}"
                            wire:model.live="cajaForm.monto_{{ !$openCaja ? 'apertura' : 'cierre' }}" suffix="PEN" />
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancelar" @click="$wire.modalCaja = false" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="save3" label="Guardar" class="bg-blue-500" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>

    <x-mary-modal wire:model="modalEntry" persistent class="backdrop-blur" box-class="max-h-full max-w-128">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="REGISTRO INGRESO" />
        <x-mary-form wire:submit="entryCaja">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2 space-x-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-select label="Tipo" :options="$tipos" wire:model="entryForm.tipo" />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Monto" wire:model="entryForm.monto_entry" suffix="S/" locale="es-PE"
                            first-error-only />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Descripción" wire:model="entryForm.description" first-error-only />
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancelar" @click="$wire.modalEntry = false" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="save3" label="Guardar" class="bg-blue-500" spinner="entryCaja" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
    
    <x-mary-modal wire:model="modalExit" persistent class="backdrop-blur" box-class="max-h-full max-w-128">
        <x-mary-icon name="s-envelope" class="text-red-500 text-md" label="REGISTRO EGRESO" />
        <x-mary-form wire:submit="exitCaja">
            <div class="border border-red-500 rounded-lg">
                <div class="grid grid-cols-4 p-2 space-x-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-select label="Tipo" :options="$tipos2" wire:model="exitForm.tipo" />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Monto" wire:model="exitForm.monto_exit" suffix="S/" locale="es-PE" />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Descripción" wire:model="exitForm.description" />
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancelar" @click="$wire.modalExit = false" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="save3" label="Guardar" class="bg-blue-500" spinner="exitCaja" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>

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