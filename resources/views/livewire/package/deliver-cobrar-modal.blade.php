@if($encomienda)
    <x-mary-modal wire:model="modalCobrar" class="backdrop-blur" box-class="max-w-6xl max-h-full bg-gray-200" separator
        progress-indicator>
        <div class="p-2 space-y-4 ">
            <!-- Información de clientes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 ">
                <!-- Remitente -->
                <div class="bg-white rounded-lg shadow-sm p-3 border-l-4 border-green-500">
                    <div class="flex items-center mb-2">
                        <x-mary-icon name="s-user" class="text-green-500 mr-2" />
                        <h3 class="font-bold text-green-700">REMITENTE2</h3>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-medium">{{ $encomienda->remitente->name ?? 'name' }}</p>
                        <p>{{ $encomienda->remitente->type_code == 1 ? 'DNI:' : 'RUC:' }}
                            {{ $encomienda->remitente->code ?? 'code' }}
                        </p>
                        @if ($encomienda->remitente->phone)
                            <p class="flex items-center"><x-mary-icon name="s-phone" class="text-gray-500 mr-1 h-4 w-4" />
                                {{ $encomienda->remitente->phone }}</p>
                        @endif
                    </div>
                </div>

                <!-- Destinatario -->
                <div class="bg-white rounded-lg shadow-sm p-3 border-l-4 border-blue-500">
                    <div class="flex items-center mb-2">
                        <x-mary-icon name="s-user" class="text-blue-500 mr-2" />
                        <h3 class="font-bold text-blue-700">DESTINATARIO</h3>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-medium">{{ $encomienda->destinatario->name ?? 'name' }}</p>
                        <p>{{ $encomienda->destinatario->type_code == 1 ? 'DNI:' : 'RUC:' }}
                            {{ $encomienda->destinatario->code ?? 'code' }}
                        </p>
                        @if ($encomienda->destinatario->phone)
                            <p class="flex items-center"><x-mary-icon name="s-phone" class="text-gray-500 mr-1 h-4 w-4" />
                                {{ $encomienda->destinatario->phone }}</p>
                        @endif
                    </div>
                </div>

                <!-- Facturación -->
                <div class="bg-white rounded-lg shadow-sm p-3 border-l-4 border-purple-500">
                    <div class="flex items-center mb-2">
                        <x-mary-icon name="s-document-text" class="text-purple-500 mr-2" />
                        <h3 class="font-bold text-purple-700">FACTURACIÓN</h3>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-medium">{{ $encomienda->facturacion->name ?? 'name' }}</p>
                        <p>{{ $encomienda->facturacion->type_code == 1 ? 'DNI:' : 'RUC:' }}
                            {{ $encomienda->facturacion->code ?? 'code' }}
                        </p>
                        @if ($encomienda->facturacion->phone)
                            <p class="flex items-center"><x-mary-icon name="s-phone" class="text-gray-500 mr-1 h-4 w-4" />
                                {{ $encomienda->facturacion->phone }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detalles de pago -->
            <div class="bg-white rounded-lg shadow-sm p-3">
                <div class="flex items-center mb-3">
                    <x-mary-icon name="s-credit-card" class="text-indigo-500 mr-2" />
                    <h3 class="font-bold text-indigo-700">DETALLE PAGO</h3>
                </div>
                @php
                    $pagos = [
                        ['id' => 'PAGADO', 'name' => 'PAGADO'],
                        ['id' => 'CONTRA ENTREGA', 'name' => 'CONTRA ENTREGA'],
                    ];
                    $comprobantes = [
                        ['id' => 'BOLETA', 'name' => 'BOLETA'],
                        ['id' => 'FACTURA', 'name' => 'FACTURA'],
                        ['id' => 'TICKET', 'name' => 'TICKET'],
                    ];
                    $metodoPagos = [
                        ['id' => 'Contado', 'name' => 'Contado'],
                        ['id' => 'Yape', 'name' => 'Yape'],
                        ['id' => 'Transferencia', 'name' => 'Transferencia'],
                        ['id' => 'Deposito', 'name' => 'Deposito'],
                    ];
                    $tipoDocuments = [
                        ['codigo' => '0', 'sigla' => 'OTRO DOCUMENTO cod(0)'],
                        ['codigo' => '1', 'sigla' => 'DNI cod(1)'],
                        ['codigo' => '6', 'sigla' => 'RUC cod(6)'],
                    ];
                @endphp
                <div class="w-full">
                    <div class="grid grid-cols-4 gap-1">
                        <div>
                            <x-mary-select label="Tipo de comprobante" icon="o-user" :options="$comprobantes"
                                    wire:model.live="tipo_comprobante" class="rounded-r-lg" />
                        </div>
                        <div>
                            @if ($encomienda->estado_pago == 'PAGADO')
                                <x-mary-select label="Tipo de comprobante" icon="o-user" :options="$comprobantes"
                                    wire:model.live="tipo_comprobante" class="rounded-r-lg" />
                            @endif
                        </div>
                        <div>
                            @if ($encomienda->estado_pago == 'PAGADO')
                                <x-mary-select label="Metodo pago" icon="o-user" :options="$metodoPagos"
                                    wire:model="metodo_pago" class="rounded-r-lg" />
                            @endif
                        </div>
                    </div>
                    @if ($encomienda->tipo_comprobante != 'TICKET' && $encomienda->estado_pago == 'PAGADO')
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
                </div>
            </div>
        </div>
        <x-slot:actions>
            <div class="flex space-x-2">
                <x-mary-button label="Cancelar" @click="$wire.modalCobrar = false"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700" />
                @if ($encomienda->estado_pago == 'CONTRA ENTREGA')
                    <x-mary-button wire:click='modalCobrarOpen({{$encomienda}})' label="Cobrar"
                        class="bg-orange-500 hover:bg-orange-700 text-white" spinner />
                @else
                    <x-mary-button wire:click='confirmEncomienda({{$encomienda}})' label="Confirmar"
                        class="bg-green-500 hover:bg-green-700 text-white" spinner />
                @endif
            </div>
        </x-slot:actions>
    </x-mary-modal>
@endif