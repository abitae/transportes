@if ($this->destinatario && $this->remitente && $this->cliFacturacion && $this->paquetes)
<x-mary-modal wire:model="modalConfimation" class="backdrop-blur" box-class="max-w-6xl max-h-full" separator>
    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
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
        <div class="col-span-1 md:col-span-2">
            <x-mary-icon name="s-envelope" class="col-span-2 text-blue-500 text-md" label="DETALLE PAGO" />
            <div class="grid grid-cols-2 gap-1">
                <div>
                    <x-mary-stat class="text-xs" title="Estado pago" value="{{ $this->estado_pago }}" icon="o-envelope"
                        tooltip="Pagado o Contra entrega" />
                </div>
                <div>
                    <x-mary-stat title="Tipo comprobante" value="{{ $this->tipo_comprobante }}" icon="o-envelope"
                        tooltip="Ticket, Boleta, Factura" />
                </div>
                <div>
                    <x-mary-stat title="Metodo de pago" value="{{ $this->metodo_pago }}" icon="o-envelope"
                        tooltip="Metodo de pago (Contado, Yape, Transferencia, Deposito)" />
                </div>
                <div>
                    @if ($isHome)
                    <x-mary-stat title="Entrega" value="DOMICILIO" icon="o-envelope" tooltip="Reparto a domicilio" />
                    @else
                    <x-mary-stat title="Entrega" value="AGENCIA" icon="o-envelope" tooltip="Reparto a agencia" />
                    @endif


                </div>
            </div>
        </div>
        <div class="col-span-4 md:col-span-4">
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
        <div class="grid grid-cols-4 gap-2 border-sky-500">
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
                    link="/sticker/a5/{{ $this->encomienda->id }}" spinner class="text-white bg-orange-500 btn-xl" />
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
        </div>
    </x-mary-card>
</x-mary-modal>
@endif
