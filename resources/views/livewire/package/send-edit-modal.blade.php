@isset($encomienda)
    <x-mary-modal wire:model="editModal" persistent class="backdrop-blur" box-class="max-h-full max-w-256">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="CAMBIAR DESTINATARIO" />
        <x-mary-form wire:submit.prevent="updateEncomienda">
            <div class="p-2 border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 gap-1">
                    <div class="grid col-span-4">
                        <x-mary-input label="Numero de documento" wire:model='customerFormDest.code'>
                            <x-slot:prepend>
                                @php
                                    $docs = [
                                        ['id' => 'dni', 'name' => 'DNI'],
                                        ['id' => 'ruc', 'name' => 'RUC'],
                                        ['id' => 'ce', 'name' => 'CE'],
                                    ];
                                @endphp
                                <x-mary-select wire:model='customerFormDest.type_code' icon="o-user" :options="$docs"
                                    class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button wire:click='searchDestinatario' icon="o-magnifying-glass"
                                    class="btn-primary rounded-s-none" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-4">
                        <x-mary-input label="Nombre/Raz. Social" wire:model='customerFormDest.name' />
                    </div>
                    <div class="grid col-span-4">
                        <hr />
                        <x-mary-toggle label="Reparto a domicilio" wire:model.live="isHome"
                            hint="Active para reparto a domicilio" />
                        <hr />
                    </div>
                    @if ($isHome)
                        <div class="grid col-span-3">
                            <x-mary-input label="Dirección" wire:model='customerFormDest.address' />
                        </div>
                        <div class="grid col-span-1">
                            <x-mary-input label="Celular" wire:model='customerFormDest.phone' />
                        </div>
                    @endif
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancelar" @click="$wire.editModal = false" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="updateEncomienda" label="Guardar" class="bg-blue-500" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
@endisset