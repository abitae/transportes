@if ($encomienda)
    <x-mary-modal wire:model="editEncomiendaModal" box-class="max-h-full max-w-4xl" title="Editar Encomienda"  separator>
        <div class="space-y-4">
            {{-- Sección de Destinatario --}}
            <div class="p-4 border border-green-500 rounded-lg">
                @php
                    $tipoDocuments = [
                        ['codigo' => '0', 'sigla' => 'OTRO cod(0)'],
                        ['codigo' => '1', 'sigla' => 'DNI cod(1)'],
                        ['codigo' => '6', 'sigla' => 'RUC cod(6)'],
                    ];
                @endphp
                <div class="grid grid-cols-4 gap-3 p-4 bg-white rounded-lg shadow-sm">
                    <div class="col-span-4 md:col-span-2">
                        <x-mary-input label="Número de documento" wire:model='destinatario_code'
                            wire:keydown.enter="searchDestinatario" wire:keydown.ctrl.enter="next"
                            placeholder="Ingrese documento">
                            <x-slot:prepend>
                                <x-mary-select wire:model='destinatario_type_code' icon="o-user" option-value="codigo"
                                    option-label="sigla" :options="$tipoDocuments" class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button wire:click.prevent='searchDestinatario' icon="o-magnifying-glass"
                                    class="btn-primary rounded-s-none hover:bg-blue-600"
                                    tooltip="Buscar destinatario" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <x-mary-input label="Nombre/Razón Social" wire:model='destinatario_name'
                            placeholder="Nombre completo" />
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <div class="p-2 my-2 border rounded-lg border-sky-200 bg-sky-50">
                            <x-mary-toggle label="Reparto a domicilio" wire:model.live="isHome"
                                hint="Active para reparto a domicilio" />
                        </div>
                    </div>
                    @if ($isHome)
                        <div class="col-span-4 md:col-span-3">
                            <x-mary-input label="Dirección" wire:model='destinatario_address'
                                placeholder="Dirección completa" icon="o-home" />
                        </div>
                        <div class="col-span-4 md:col-span-1">
                            <x-mary-input label="Celular" wire:model='destinatario_phone' placeholder="999999999"
                                icon="o-device-phone-mobile" />
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 p-2 bg-white rounded-lg shadow-sm md:grid-cols-4">
                <div class="col-span-1 md:col-span-1">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-mary-input label="CANTIDAD" wire:model="cantidad" class="text-xs font-medium"
                                placeholder="0" />
                        </div>
                        <div>
                            <x-mary-select label="UNIDAD" :options="$unidadMedidas" wire:model="und_medida"
                                option-value="codigo" option-label="descripcion" placeholder="Seleccione" />
                        </div>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <x-mary-input label="DESCRIPCIÓN" wire:model="description" placeholder="Descripción del paquete"
                        icon="o-clipboard-document-list" />
                </div>
                <div class="col-span-1 md:col-span-1">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-mary-input label="PESO" wire:model="peso" suffix="KG" locale="es-PE"
                                placeholder="0.00" />
                        </div>
                        <div>
                            <div class="flex flex-col">
                                <x-mary-input label="MONTO" wire:model="amount" suffix="S/"
                                    wire:keydown.enter="addPaquete" wire:keydown.ctrl.enter="addPaquete"
                                    placeholder="0.00" />
                                <div class="flex justify-end gap-2 mt-2">
                                    <x-mary-button icon="o-plus" wire:click='addPaquete'
                                        class="text-white rounded-lg bg-sky-500 hover:bg-sky-600"
                                        tooltip="Agregar paquete" />
                                    <x-mary-button icon="o-trash" wire:click='resetPaquete'
                                        class="text-white bg-red-500 hover:bg-red-600 rounded-lg"
                                        tooltip="Limpiar campos" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-0">
                <x-mary-card shadow separator>
                    <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped hover
                        @row-click="$wire.restPaquete($event.detail.id)">
                        <x-slot:empty>
                            <div class="flex flex-col items-center justify-center py-6 space-y-2 text-gray-500">
                                <x-mary-icon name="o-cube" class="w-12 h-12" />
                                <p>No hay paquetes registrados</p>
                                <p class="text-sm">Agregue paquetes utilizando el formulario superior</p>
                            </div>
                        </x-slot:empty>
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <x-slot:actions>
            <div class="flex justify-end space-x-3">
                <x-mary-button label="Cancelar" @click="$wire.editEncomiendaModal = false"
                    class="bg-red-500 hover:bg-red-600" />
                <x-mary-button type="submit" wire:click="updateEncomienda" spinner="updateEncomienda"
                    label="Guardar Cambios" class="bg-blue-500 hover:bg-blue-600" />
            </div>
        </x-slot:actions>
    </x-mary-modal>
@endif
