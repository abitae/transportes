<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator class="max-w-6xl">
        <x-slot:menu>
            <x-mary-button @click="$wire.showHistory = true" icon="s-eye" label="Historial"
                class="text-white bg-purple-500" responsive />
        </x-slot:menu>
        @php
        $users = App\Models\User::take(5)->get();
        @endphp
        <div class="grid grid-cols-3 grid-rows-2 gap-1">
            <div>
                <x-mary-select label="Tipo Doc.Ident." icon="o-user" option-value="codigo"
                option-label="sigla" :options="$tipoDocuments" wire:model.live="tipoDocumento" class="max-w-sm" />
            </div>
            <div>
                <x-mary-input label="Documento" wire:model.live="numDocumento" class="max-w-sm">
                    <x-slot:append>
                        <x-mary-button wire:click='buscarDocumento' icon="o-magnifying-glass" class="btn-primary rounded-s-none" />
                    </x-slot:append>
                </x-mary-input>
            </div>
            <div>
                <x-mary-input label="Razon Social" wire:model.live='razonSocial'  class="h-12 max-w-sm" />
            </div>
            <div class="row-start-2">
                <x-mary-input label="Direccion" wire:model.live='direccion' class="h-12 max-w-sm" />
            </div>
            <div class="row-start-2">
                <x-mary-select label="Ubigeo" option-value="ubigeo2"
                option-label="texto_ubigeo" wire:model.live='ubigeo' :options="$ubigeos" wire:model="selectedUser" class="max-w-sm" />
            </div>
            <div class="row-start-2">
                <x-mary-input label="Telefono" wire:model.live='telefono' class="h-12 max-w-sm" />
            </div>
        </div>
        <div class="flex justify-end pt-4 pb-2">
            
            <x-mary-button label="Agregar Producto"  icon="o-plus" class="text-white bg-green-500" />
        </div>
        <div>
            @php
            $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nice Name'],

            ];
            @endphp

            <x-mary-table :headers="$headers" :rows="$users" class="max-w-full border-t">

                {{-- Notice `$user` is the current row item on loop --}}
                @scope('cell_id', $user)
                <strong>{{ $user->id }}</strong>
                @endscope

                {{-- You can name the injected object as you wish --}}
                @scope('cell_name', $stuff)
                <x-mary-badge :value="$stuff->name" class="badge-info" />
                @endscope



                {{-- Special `actions` slot --}}
                @scope('actions', $user)
                <x-mary-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" />
                @endscope

            </x-mary-table>
        </div>

        <div class="grid grid-cols-3 grid-rows-4 gap-1 border-t">
            <div class="col-span-2"></div>
            <div class="col-span-2 col-start-1 row-start-2">SON CIEN CON 00/100 SOLES</div>
            <div class="col-span-2 col-start-1 row-start-3">OPERACION SUJETA A DETRACCION</div>
            <div class="col-span-3 col-start-1 row-start-4">NOTA</div>
            <div class="col-start-3 row-span-3 row-start-1">
                <div class="grid grid-cols-2 gap-1 gap-y-2">
                    <div>Resumen</div>
                    <div></div>
                    <div class="border-t">Sub Total</div>
                    <div class="text-right border-t">S/ 100.00</div>
                    <div class="border-t">IGV</div>
                    <div class="text-right border-t">S/ 100.00</div>
                    <div class="border-t border-b"><strong>Total</strong></div>
                    <div class="text-xl text-right text-blue-500 border-t">S/ 100.00</div>
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <x-mary-button label="Guardar" icon="o-plus" class="btn-primary" />
        </div>
    </x-mary-card>
</div>
