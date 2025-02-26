@if ($encomienda->monto_descuento)
<x-mary-button label="QUITAR DESCUENTO" icon="o-currency-dollar" wire:click="descuentoDelete({{ $encomienda->id }})"
    spinner class="w-full mt-2 text-white bg-purple-500 btn-xs" />
@elseif ($tipo_comprobante == 'TICKET')
<x-mary-button label="ASIGNAR DESCUENTO" icon="o-currency-dollar" wire:click="descuento({{ $encomienda->id }})" spinner
    class="w-full mt-2 text-white bg-purple-500 btn-xs" />
@endif
<x-mary-modal wire:model="modalDescuento" persistent class="backdrop-blur" box-class="max-w-md max-h-full">
    <x-mary-card shadow>
        <x-mary-icon name="s-envelope" class="text-blue-500 text-md" label="DESCUENTO" />
        <x-mary-input label="Monto" wire:model.live='monto_descuento' />
        <x-mary-input label="Motivo" wire:model.live='motivo_descuento' />
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.modalDescuento = false" class="bg-red-500" />
            <x-mary-button type="submit" spinner="descuentoCreate" label="Guardar" class="bg-blue-500" />
        </x-slot:actions>
    </x-mary-card>
</x-mary-modal>