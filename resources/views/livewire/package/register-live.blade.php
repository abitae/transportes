<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow>
        <x-slot:menu>
            <x-mary-input label="Buscar envio" inline wire:model.live='search' />
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo envio"
                class="text-white shadow-xl bg-sky-500" />
        </x-slot:menu>
        <x-mary-steps wire:model="step" steps-color="step-warning"
            class="p-2 my-5 border rounded-lg shadow-xl border-sky-500">
            <x-mary-step step="1" text="Remitente">
                @php
                    $users = App\Models\User::take(5)->get();
                @endphp
                <div class="grid grid-cols-4 gap-1">
                    <div class="grid col-span-2">
                        <x-mary-input label="Numero de documento" wire:model='customerForm.code'>
                            <x-slot:prepend>
                                <x-mary-select wire:model='customerForm.type_code' icon="o-user" :options="$docs"
                                    class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button wire:click='searchRemitente' icon="o-magnifying-glass"
                                    class="btn-primary rounded-s-none" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-2">
                        <x-mary-input label="Nombre/Raz. Social" wire:model='customerForm.name'>

                        </x-mary-input>
                    </div>
                    <div class="grid col-span-3">
                        <x-mary-input label="Direccion" wire:model='customerForm.address'>

                        </x-mary-input>
                    </div>
                    <div class="grid col-span-1">
                        <x-mary-input label="Celular" wire:model='customerForm.phone'>

                        </x-mary-input>
                    </div>

                </div>
            </x-mary-step>
            <x-mary-step step="2" text="Destinatario">
                <div class="grid grid-cols-4 gap-1">
                    <div class="grid col-span-2">
                        <x-mary-input label="Numero de documento" wire:model='customerFormDest.code'>
                            <x-slot:prepend>
                                <x-mary-select wire:model='customerFormDest.type_code' icon="o-user" :options="$docs"
                                    class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button wire:click='searchDestinatario' icon="o-magnifying-glass"
                                    class="btn-primary rounded-s-none" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-2">
                        <x-mary-input label="Nombre/Raz. Social" wire:model='customerFormDest.name'>

                        </x-mary-input>
                    </div>
                    <div class="grid col-span-3">
                        <x-mary-input label="Direccion" wire:model='customerFormDest.address'>

                        </x-mary-input>
                    </div>
                    <div class="grid col-span-1">
                        <x-mary-input label="Celular" wire:model='customerFormDest.phone'>

                        </x-mary-input>
                    </div>

                </div>
            </x-mary-step>
            <x-mary-step step="3" text="Paquetes">
                <div class="grid grid-cols-8 gap-1">
                    <div class="grid col-span-1">
                        <x-mary-input label="CANT." wire:model="cantidad" class="rounded-r-lg" />
                    </div>
                    <div class="grid col-span-4">
                        <x-mary-input label="DESCRIPCION" wire:model="description" class="rounded-r-lg" />
                    </div>
                    <div class="grid col-span-1">
                        <x-mary-input label="PESO (KG)" wire:model="peso" suffix="KG" locale="es-PE" />
                    </div>
                    <div class="grid col-span-1">
                        <x-mary-input label="MONTO" wire:model="amount" suffix="S/" />
                    </div>
                    <div class="flex items-end">
                        <x-mary-button icon="o-plus" wire:click='addPaquete'
                            class="text-white rounded-lg bg-sky-500" />
                    </div>
                    <div class="grid col-span-8">
                        <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped>
                            <x-slot:empty>
                                <x-mary-icon name="o-cube" label="No se encontro registros." />
                            </x-slot:empty>

                        </x-mary-table>
                    </div>
                </div>
            </x-mary-step>
            <x-mary-step step="4" text="Destino" data-content="✓" step-classes="!step-success">

                <div class="grid grid-cols-8 gap-1">
                    <div class="grid col-span-3">
                        <x-mary-select label="Sucursal" icon="o-user" :options="$sucursales" class="rounded-r-lg"
                            wire:model="sucursal_dest_id" />
                    </div>
                    <div class="grid col-span-1">

                    </div>
                    <div class="grid col-span-2">
                        <x-mary-icon name="o-hashtag" label="PING" />
                        <x-mary-pin wire:model="pin1" size="3" numeric />
                    </div>
                    <div class="grid col-span-2">
                        <x-mary-icon name="o-hashtag" label="CONFIRMACION" />
                        <x-mary-pin wire:model="pin2" size="3" numeric />
                    </div>
                    <div class="grid col-span-8">
                        <x-mary-input label="Documento de traslado" wire:model="doc_traslado" class="rounded-r-lg" />
                    </div>
                    <div class="grid col-span-8">
                        <x-mary-textarea label="Glosa" wire:model="glosa" placeholder="Escribe una glosa"
                            hint="Max 1000 chars" rows="2" inline class="rounded-r-lg" />
                    </div>
                </div>
            </x-mary-step>
        </x-mary-steps>
        <x-slot:actions>
            @if ($step != 1)
                <x-mary-button label="Anterior" wire:click="prev" class='shadow-xl' />
            @endif
            @if ($step == 4)
                <x-mary-button label="Finish" wire:click="finish" class='shadow-xl' />
            @else
                <x-mary-button label="Siguiente" wire:click="next" class='shadow-xl' />
            @endif
        </x-slot:actions>
    </x-mary-card>
    <x-mary-modal wire:model="modalConfimation" persistent class="backdrop-blur"
        box-class="max-w-full max-h-full bg-red-50">
        <div class="grid grid-cols-8 border rounded-lg border-sky-500">
            <div class="grid col-span-4 p-2 space-y-2">
                <div class="grid grid-cols-8 border rounded-lg border-sky-500">
                    <div class="grid col-span-8">
                        <x-mary-card shadow>
                            @php
                                $user2 = App\Models\User::inRandomOrder()->first();
                            @endphp

                            <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="REMITENTE" />
                            <div class="grid grid-cols-5 grid-rows-5 gap-1">
                                <div class="col-span-3">{{ $this->customerForm->name ?? 'name'  }}</div>
                                <div class="row-start-2">{{ $this->customerForm->type_code ?? 'type_code'  }}</div>
                                <div class="row-start-2">{{ $this->customerForm->code ?? 'code'  }}</div>
                                <div class="row-start-2">{{ $this->customerForm->phone ?? 'phone'  }}</div>
                            </div>


                            <x-mary-icon name="s-envelope" class="text-red-500 text-md" label="DESTINATARIO" />
                            <div class="grid grid-cols-5 grid-rows-5 gap-1">
                                <div class="col-span-3">{{ $this->customerFormDest->name ?? 'name'  }}</div>
                                <div class="row-start-2">{{ $this->customerFormDest->type_code ?? 'type_code'  }}</div>
                                <div class="row-start-2">{{ $this->customerFormDest->code ?? 'code'  }}</div>
                                <div class="row-start-2">{{ $this->customerFormDest->phone ?? 'phone'  }}</div>
                            </div>

                            <x-mary-icon name="s-envelope" class="text-blue-500 text-md" label="ENTREGA" />
                            <x-mary-list-item :item="$user2" separator>
                                <x-slot:value>
                                    <x-mary-badge value="AGENCIA LIMA 342" class="text-white bg-purple-500" />
                                </x-slot:value>
                            </x-mary-list-item>
                            <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="DETALLE PAQUETES" />
                            <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped
                                @row-click="alert($event.detail.name)">
                                {{-- You can name the injected object as you wish  --}}
                                @scope('cell_name', $user)
                                    <x-mary-badge :value="$user->name" class="badge-info" />
                                @endscope
                                {{-- Special `actions` slot --}}
                                
                            </x-mary-table>
                        </x-mary-card>

                    </div>
                </div>
            </div>
            <div class="grid col-span-4 p-2">
                <div class="grid grid-cols-8 border rounded-lg border-sky-500">
                    <div class="grid col-span-8 space-y-2">
                        <x-mary-card shadow>
                            <x-mary-icon name="s-envelope" class="text-blue-500 text-md" label="DETALLE PAGO" />
                            <x-mary-radio class="w-full max-w-full py-0 text-xs" :options="$pagos" option-value="id"
                                option-label="name" wire:model="pago" />
                            <x-mary-icon name="s-envelope" class="text-red-500 text-md"
                                label="DETALLE COMPROBANTE" />
                            <x-mary-radio class="w-full max-w-full py-0 text-xs" :options="$comprobantes" option-value="id"
                                option-label="name" wire:model="comprobante" />
                            <x-mary-icon name="s-envelope" class="text-green-500 text-md"
                                label="DETALLE FACTURACION" />
                            <div class="space-y-2">
                                <div class="grid grid-cols-4 p-2 space-x-2 border rounded-lg border-sky-500">
                                    <div class="grid col-span-1 pt-2">
                                        <x-mary-select label="TIPO DOC." :options="$users"
                                            wire:model="selectedUser3" />
                                    </div>
                                    <div class="grid col-span-3 pt-2">
                                        <x-mary-input label="NUMERO DOCUMENTO">
                                            <x-slot:append>
                                                <x-mary-button icon="o-magnifying-glass"
                                                    class="btn-primary rounded-s-none" />
                                            </x-slot:append>
                                        </x-mary-input>
                                    </div>
                                    <div class="grid col-span-2 pt-2">
                                        <x-mary-input label="RAZON SOCIAL" inline>
                                        </x-mary-input>
                                    </div>
                                    <div class="grid col-span-2 pt-2">
                                        <x-mary-input label="DIRECCION" inline>
                                        </x-mary-input>
                                    </div>
                                    <div class="grid col-span-4 pt-2">
                                        <x-mary-select label="UBIGEO" :options="$users" wire:model="selectedUser3"
                                            inline />
                                    </div>
                                </div>

                            </div>
                        </x-mary-card>
                    </div>
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.modalConfimation = false" />
                <x-mary-button label="Confirm" class="btn-primary" />
            </x-slot:actions>
        </div>
    </x-mary-modal>
</div>
