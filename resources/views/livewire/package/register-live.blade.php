<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow>
        <x-slot:menu>
            <x-mary-input label="Buscar envio" inline wire:model.live='search' />
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo envio"
                class="text-white shadow-xl bg-sky-500"/>
        </x-slot:menu>
        <x-mary-steps wire:model="step" steps-color="step-warning"
            class="p-2 my-5 border rounded-lg shadow-xl border-sky-500">
            <x-mary-step step="1" text="Remitente">
                @php
                    $users = App\Models\User::take(5)->get();
                @endphp
                <div class="grid grid-cols-4 gap-1">
                    <div class="grid col-span-2">
                        <x-mary-input label="Numero de documento">
                            <x-slot:prepend>
                                @php
                                    $docs = [
                                        ['id' => 'dni', 'name' => 'DNI'],
                                        ['id' => 'ruc', 'name' => 'RUC'],
                                        ['id' => 'ce', 'name' => 'CE'],
                                    ];
                                @endphp
                                <x-mary-select wire:model='customerForm.type_code' icon="o-user" :options="$docs"
                                    class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button icon="o-magnifying-glass" class="btn-primary rounded-s-none" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-2">
                        <x-mary-input label="Nombre/Raz. Social">

                        </x-mary-input>
                    </div>
                    <div class="grid col-span-3">
                        <x-mary-input label="Direccion">

                        </x-mary-input>
                    </div>
                    <div class="grid col-span-1">
                        <x-mary-input label="Celular">

                        </x-mary-input>
                    </div>

                </div>
            </x-mary-step>
            <x-mary-step step="2" text="Destinatario">
                <div class="grid grid-cols-4 gap-1">
                    <div class="grid col-span-2">
                        <x-mary-input label="Numero de documento">
                            <x-slot:prepend>
                                @php
                                    $docs = [
                                        ['id' => 'dni', 'name' => 'DNI'],
                                        ['id' => 'ruc', 'name' => 'RUC'],
                                        ['id' => 'ce', 'name' => 'CE'],
                                    ];
                                @endphp
                                <x-mary-select wire:model='customerForm.type_code' icon="o-user" :options="$docs"
                                    class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button icon="o-magnifying-glass" class="btn-primary rounded-s-none" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-2">
                        <x-mary-input label="Nombre/Raz. Social">

                        </x-mary-input>
                    </div>
                    <div class="grid col-span-3">
                        <x-mary-input label="Direccion">

                        </x-mary-input>
                    </div>
                    <div class="grid col-span-1">
                        <x-mary-input label="Celular">

                        </x-mary-input>
                    </div>

                </div>
            </x-mary-step>
            <x-mary-step step="3" text="Paquetes">
                <div class="grid grid-cols-8 gap-1">
                    <div class="grid col-span-1">
                        <x-mary-input label="CANT." wire:model="money1" class="rounded-r-lg" />
                    </div>
                    <div class="grid col-span-4">
                        <x-mary-input label="DESCRIPCION" wire:model="money1" class="rounded-r-lg" />
                    </div>
                    <div class="grid col-span-1">
                        <x-mary-input label="PESO (KG)" wire:model="money1" suffix="KG" locale="es-PE" />
                    </div>
                    <div class="grid col-span-1">
                        <x-mary-input label="MONTO" wire:model="money1" suffix="S/" locale="es-PE" money />
                    </div>
                    <div class="flex items-end">
                        <x-mary-button icon="o-plus" class="text-white rounded-lg bg-sky-500" />
                    </div>
                    <div class="grid col-span-8">
                        <x-mary-table :headers="$headers2" :rows="$users2" striped
                            @row-click="alert($event.detail.name)">
                            {{-- You can name the injected object as you wish  --}}
                            @scope('cell_name', $user)
                                <x-mary-badge :value="$user->name" class="badge-info" />
                            @endscope
                            {{-- Special `actions` slot --}}
                            @scope('actions', $user)
                                <x-mary-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner
                                    class="btn-sm" />
                            @endscope
                        </x-mary-table>
                    </div>
                </div>


            </x-mary-step>
            <x-mary-step step="4" text="Destino" data-content="✓" step-classes="!step-success">

                <div class="grid grid-cols-8 gap-1">
                    <div class="grid col-span-3">
                        @php
                            $users3 = App\Models\User::take(5)->get();
                        @endphp
                        <x-mary-select label="Sucursal" icon="o-user" :options="$users3" class="rounded-r-lg"
                            wire:model="selectedUser" />
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
                        <x-mary-input label="Documento de traslado" wire:model="money1" class="rounded-r-lg" />
                    </div>
                    <div class="grid col-span-8">
                        <x-mary-textarea label="Glosa" wire:model="bio" placeholder="Escribe una glosa"
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

</div>
