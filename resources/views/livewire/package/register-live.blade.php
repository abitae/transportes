<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator
        progress-indicator>
        <x-mary-steps wire:model="step" steps-color="step-warning"
            class="p-2 my-5 border rounded-lg shadow-xl border-sky-500">
            <x-mary-step step="1" text="Remitente">
                <div class="grid grid-cols-4 gap-1">
                    <div class="grid col-span-4 md:col-span-2">
                        <x-mary-input label="Numero de documento" wire:model='remitente_code'>
                            <x-slot:prepend>
                                <x-mary-select wire:model='remitente_type_code' icon="o-user" :options="$tipoDocuments"
                                    option-value="codigo" option-label="sigla" class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button wire:click='searchRemitente' icon="o-magnifying-glass"
                                    class="btn-primary rounded-s-none" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-4 md:col-span-2">
                        <x-mary-input label="Nombre/Raz. Social" wire:model='remitente_name' />
                    </div>
                    <div class="grid col-span-4 md:col-span-3">
                        <x-mary-input label="Direccion" wire:model='remitente_address' />
                    </div>
                    <div class="grid col-span-4 md:col-span-1">
                        <x-mary-input label="Celular" wire:model='remitente_phone' />
                    </div>
                </div>
            </x-mary-step>
            <x-mary-step step="2" text="Destinatario">
                <div class="grid grid-cols-4 gap-1">
                    <div class="grid col-span-4 md:col-span-2">
                        <x-mary-input label="Numero de documento" wire:model='destinatario_code'>
                            <x-slot:prepend>
                                <x-mary-select wire:model='destinatario_type_code' icon="o-user" option-value="codigo"
                                    option-label="sigla" :options="$tipoDocuments" class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button wire:click.prevent='searchDestinatario' icon="o-magnifying-glass"
                                    class="btn-primary rounded-s-none" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-4 md:col-span-2">
                        <x-mary-input label="Nombre/Raz. Social" wire:model='destinatario_name' />
                    </div>
                    <div class="grid col-span-4 md:col-span-2">
                        <hr />
                        <x-mary-toggle label="Reparto a domicilio" wire:model.live="isHome"
                            hint="Active para reparto a domicilio" />
                        <hr />
                    </div>
                    @if ($isHome)
                        <div class="grid col-span-4 md:col-span-3">
                            <x-mary-input label="Direccion" wire:model='destinatario_address' />
                        </div>
                        <div class="grid col-span-4 md:col-span-1">
                            <x-mary-input label="Celular" wire:model='destinatario_phone' />
                        </div>
                    @endif
                </div>
            </x-mary-step>
            <x-mary-step step="3" text="Paquetes">
                <div class="grid grid-cols-1 gap-1 md:grid-cols-4">
                    <div class="col-span-1 md:col-span-1">
                        <div class="grid grid-cols-2 gap-1">
                            <div>
                                <x-mary-input label="CANT." wire:model="cantidad" class="text-xs rounded-r-lg" />
                            </div>
                            <div>
                                <x-mary-select label="MEDIDA" :options="$unidadMedidas" wire:model="und_medida"
                                    option-value="codigo" option-label="descripcion" />
                            </div>
                        </div>

                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <x-mary-input label="DESCRIPCION" wire:model="description" class="rounded-r-lg" />
                    </div>
                    <div class="col-span-1 md:col-span-1">
                        <div class="grid grid-cols-2 gap-1">
                            <div>
                                <x-mary-input label="PESO (KG)" wire:model="peso" suffix="KG" locale="es-PE" />
                            </div>
                            <div>
                                <x-mary-input label="MONTO" wire:model="amount" suffix="S/" />
                                <div>
                                    <x-mary-button icon="o-plus" wire:click='addPaquete'
                                        class="text-white rounded-lg bg-sky-500 btn-xs" />
                                    <x-mary-button icon="o-no-symbol" wire:click='resetPaquete'
                                        class="text-white bg-red-500 rounded-lg btn-xs" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-8 gap-1">
                    <div class="col-span-8">
                        <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped
                            @row-click="$wire.restPaquete($event.detail.id)">
                            <x-slot:empty>
                                <x-mary-icon name="o-cube" label="No se encontro registros." />
                            </x-slot:empty>
                        </x-mary-table>
                    </div>
                </div>
            </x-mary-step>
            <x-mary-step step="4" text="Facturacion">
                <div class="grid grid-cols-4 gap-1">
                    <div>
                        <x-mary-select label="Tipo de pago" icon="o-user" :options="$pagos"
                            wire:model.live="estado_pago" class="rounded-r-lg" />
                    </div>
                    <div>
                        @if ($estado_pago == 'PAGADO')
                            <x-mary-select label="Tipo de comprobante" icon="o-user" :options="$comprobantes"
                                wire:model.live="tipo_comprobante" class="rounded-r-lg" />
                        @endif
                    </div>
                    <div>
                        @if ($estado_pago == 'PAGADO')
                            <x-mary-select label="Metodo pago" icon="o-user" :options="$metodoPagos"
                                wire:model="metodo_pago" class="rounded-r-lg" />
                        @endif
                    </div>
                </div>
                @if ($tipo_comprobante != 'TICKET' && $estado_pago == 'PAGADO')
                    <div class="grid grid-cols-4 gap-1">
                        <div class="grid col-span-4 md:col-span-2">
                            <x-mary-input label="Numero de documento" wire:model='cliFacturacion_code'>
                                <x-slot:prepend>
                                    <x-mary-select wire:model.live='cliFacturacion_type_code' icon="o-user"
                                        option-value="codigo" option-label="sigla" :options="$tipoDocuments"
                                        class="rounded-e-none" />
                                </x-slot:prepend>
                                <x-slot:append>
                                    <x-mary-button wire:click='searchFacturacion' icon="o-magnifying-glass"
                                        class="btn-primary rounded-s-none" />
                                </x-slot:append>
                            </x-mary-input>
                        </div>
                        <div class="grid col-span-4 md:col-span-2">
                            <x-mary-input label="Nombre/Raz. Social" wire:model='cliFacturacion_name' />
                        </div>
                        <div class="grid col-span-4 md:col-span-3">
                            <x-mary-input label="Direccion" wire:model='cliFacturacion_address' />
                        </div>
                        <div class="grid col-span-4 md:col-span-1">
                            <x-mary-input label="Celular" wire:model='cliFacturacion_phone' />
                        </div>
                    </div>
                @endif
            </x-mary-step>
            <x-mary-step step="5" text="Destino" data-content="✓" step-classes="!step-success">
                <div class="grid grid-cols-8 gap-1">
                    <div class="grid col-span-4">
                        <x-mary-select label="Sucursal" icon="o-user" :options="$sucursales" class="rounded-r-lg"
                            wire:model.live="sucursal_dest_id" />
                        <x-mary-toggle label="Retorno de guia" wire:model="isReturn"
                            hint="Active para retorno de guia" />
                    </div>
                    <div class="grid col-span-4">
                        @if (!$isHome)
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <div>
                                    <x-mary-icon name="o-hashtag" label="PING" />
                                    <x-mary-pin ida="pin1" wire:model="pin1" size="3" hide
                                        hide-type="circle" />
                                </div>
                                <div>
                                    <x-mary-icon name="o-hashtag" label="CONFIRMACION" />
                                    <x-mary-pin ida="pin2" wire:model="pin2" size="3" hide
                                        hide-type="circle" />
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="grid col-span-4">
                        @php
                            $tiposDocTraslado = [
                                ['id' => '0', 'name' => 'S/G'],
                                ['id' => '1', 'name' => 'Factura'],
                                ['id' => '3', 'name' => 'Boleta'],
                                ['id' => '7', 'name' => 'Guia de remision'],
                                ['id' => '31', 'name' => 'Guia de remision de transporte'],
                            ];
                        @endphp
                        <div class="flex flex-row gap-2">
                            <x-mary-select label="Tipo de documento" icon="o-user" :options="$tiposDocTraslado"
                                wire:model.live="tipoDocTraslado" class="rounded-r-lg" />
                            @switch($tipoDocTraslado)
                                @case('0')
                                    @php $placeholder = 'S/G' @endphp
                                @break

                                @case('1')
                                    @php $placeholder = 'F001-001' @endphp
                                @break

                                @case('3')
                                    @php $placeholder = 'B001-001' @endphp
                                @break

                                @case('7')
                                    @php $placeholder = 'T001-001' @endphp
                                @break

                                @case('31')
                                    @php $placeholder = 'V001-001' @endphp
                                @break
                            @endswitch
                            @if ($tipoDocTraslado != '0')
                                <x-mary-input label="Documento" wire:model="docTraslado"
                                    class="rounded-r-lg" placeholder="{{ $placeholder ?? 'S/G' }}" />
                                <x-mary-input label="RUC del emisor" placeholder="10436493903"
                                    wire:model="emisorDocTraslado" class="rounded-r-lg" />
                            @endif
                        </div>
                    </div>
                    <div class="grid col-span-4">

                    </div>
                    <div class="grid col-span-4">
                        <x-mary-textarea label="Glosa" wire:model="glosa" placeholder="Escribe una glosa"
                            hint="Max 1000 chars" rows="2" inline class="rounded-r-lg" />
                    </div>
                    <div class="grid col-span-4">
                        <x-mary-textarea label="Observaciones" wire:model="observation" placeholder="Observaciones"
                            hint="Max 1000 chars" rows="2" inline class="rounded-r-lg" />
                    </div>
                    <div class="grid col-span-4">
                        <x-mary-select label="Transportista" icon="o-user" :options="$transportistas"
                            wire:model.live="transportista_id" inline />
                    </div>
                    <div class="grid col-span-4">
                        <x-mary-select label="Vehiculo" icon="o-user" :options="$vehiculos"
                            wire:model.live="vehiculo_id" inline />
                    </div>
                </div>
            </x-mary-step>
        </x-mary-steps>
        <x-slot:actions>
            @if ($step != 1)
                <x-mary-button label="Anterior" wire:click="prev" class='shadow-xl' />
            @endif
            @if ($step == 5)
                <x-mary-button label="Confirmacion" wire:click="finish" class='shadow-xl' />
            @else
                <x-mary-button label="Siguiente" wire:click="next" class='shadow-xl' />
            @endif
        </x-slot:actions>
    </x-mary-card>
    @include('livewire.package.register-modal')
    @include('livewire.package.register-final-modal')
</div>
