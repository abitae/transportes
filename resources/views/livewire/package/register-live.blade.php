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
                                <x-mary-pin ida="pin1" wire:model="pin1" size="3" hide hide-type="circle" />
                            </div>
                            <div>
                                <x-mary-icon name="o-hashtag" label="CONFIRMACION" />
                                <x-mary-pin ida="pin2" wire:model="pin2" size="3" hide hide-type="circle" />
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="grid col-span-4">
                        <x-mary-input label="Documento de traslado" wire:model="doc_traslado" class="rounded-r-lg"
                            inline />
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
    <div>
        <div>
            {{ $remitente ?? 'remitente' }}
        </div>
        <div>
            {{ $destinatario ?? 'destinatario' }}
        </div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    @if ($this->destinatario && $this->remitente && $this->paquetes)
    <x-mary-modal wire:model="modalConfimation" class="backdrop-blur" box-class="max-w-6xl max-h-full" separator>
        <div class="grid grid-cols-2 gap-1 md:grid-cols-4">
            <div>
                <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="REMITENTE" />
                <ul>
                    <li>
                        {{ $this->remitente->name ?? 'name' }}
                    </li>
                    <li>
                        {{ $this->remitente->type_code = 1 ? 'DNI:' : 'RUC:' }} {{ $this->remitente->code ??
                        'code'
                        }}
                    </li>
                    @if ($this->remitente->phone)
                    <li>Telefono: {{ $this->remitente->phone }}</li>
                    @endif

                </ul>
            </div>
            <div>
                <x-mary-icon name="s-envelope" class="col-span-2 text-blue-500 text-md" label="DESTINATARIO" />
                <ul>
                    <li>{{ $this->destinatario->name ?? 'name' }}</li>
                    <li>{{ $this->destinatario->type_code = 1 ? 'DNI:' : 'RUC:' }} {{ $this->destinatario->code ??
                        'code'
                        }}</li>
                    @if ($this->destinatario->phone)
                    <li>Telefono: {{ $this->destinatario->phone }}</li>
                    @endif
                </ul>
            </div>
            <div>
                <x-mary-icon name="s-envelope" class="col-span-2 text-blue-500 text-md" label="FACTURACION" />
                <ul>
                    <li>{{ $this->cliFacturacion->name ?? 'name' }}</li>
                    <li>{{ $this->cliFacturacion->type_code = 1 ? 'DNI:' : 'RUC:' }} {{ $this->cliFacturacion->code ??
                        'code'
                        }}</li>
                    @if ($this->cliFacturacion->phone)
                    <li>Telefono: {{ $this->cliFacturacion->phone }}</li>
                    @endif
                </ul>
            </div>
            <div>
                <x-mary-icon name="s-envelope" class="col-span-2 text-blue-500 text-md" label="DETALLE PAGO" />
                <ul>
                    <x-mary-stat title="Estado pago" value="{{ $this->estado_pago }}" icon="o-envelope"
                        tooltip="Pagao o Contra entrega" />
                    <x-mary-stat title="Tipo conprobante" value="{{ $this->tipo_comprobante }}" icon="o-envelope"
                        tooltip="Ticket, Boleta, Factura" />
                    <x-mary-stat title="Metodo de pago" value="{{ $this->metodo_pago }}" icon="o-envelope"
                        tooltip="Metodo de pago (Contado, Yape, Transferencia, Deposito)" />

                </ul>
            </div>
            <div class="col-span-2 md:col-span-4">
                <x-mary-icon name="s-envelope" class="text-sky-500 text-md" label="DETALLE PAQUETES" />
                <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped>
                </x-mary-table>
                <div class="text-right text-blue-500 border-t text-md">
                    Total S/{{ number_format($paquetes->sum('sub_total'), 2) }}
                </div>
            </div>
        </div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.modalConfimation = false" />
            <x-mary-button wire:click='confirmEncomienda' wire: label="Confirm" class="btn-primary" spinner />
        </x-slot:actions>
    </x-mary-modal>
    @endif
    @if ($this->encomienda)
    <x-mary-modal wire:model.live="modalFinal" persistent class="backdrop-blur" box-class="w-full">
        <x-mary-card shadow>
            <div class="grid grid-cols-4 grid-rows-2 gap-2 border-sky-500">
                <div>
                    @if ($this->encomienda->ticket)
                    <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="TICKET"
                        link="/ticket/80mm/{{ $this->encomienda->ticket->id }}" spinner
                        class="text-white bg-green-500 btn-xl" />
                    @endif
                </div>
                <div>
                    @if ($this->encomienda->invoice)
                    <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="RECIBO"
                        link="/invoice/80mm/{{ $this->encomienda->invoice->id }}" spinner
                        class="text-white bg-cyan-500 btn-xl" />
                    @endif
                </div>
                <div>
                    <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="GUIA T"
                        link="/despache/80mm/{{ $this->encomienda->despatche->id }}" spinner
                        class="text-white bg-blue-500 btn-xl" />
                </div>
                <div>
                    <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="STICKER"
                        link="/sticker/a5/{{ $this->encomienda->id }}" spinner
                        class="text-white bg-orange-500 btn-xl" />
                </div>
                <div>
                    <x-mary-button icon="o-clipboard" link="{{ route('package.register') }}" spinner label="NUEVO"
                        class="text-white bg-blue-500 btn-xl" />
                </div>
                <div>
                    <x-mary-button icon="s-list-bullet" link="{{ route('package.send') }}" spinner label="LISTA E"
                        class="text-white bg-blue-500 btn-xl" />
                </div>
                <div>
                    <x-mary-button icon="o-cursor-arrow-ripple" link="{{ route('package.deliver') }}" no-wire-navigate
                        label="ENTREGAR" spinner class="text-white bg-blue-500 btn-xl" />
                </div>
                <div>
                </div>
            </div>
        </x-mary-card>
    </x-mary-modal>
    @endif
</div>
