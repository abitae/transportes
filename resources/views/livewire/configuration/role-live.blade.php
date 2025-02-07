<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo rol"
                class="text-white bg-sky-500" />
        </x-slot:menu>
    </x-mary-card>
    <div class="grid grid-cols-4 space-x-2">
        <div class="grid col-span-4 pt-2">
            <x-mary-card shadow separator>
                @php
                $headers = [
                ['key' => 'id', 'label' => '#', 'class' => 'bg-purple-500 w-1 text-white'],
                ['key' => 'name', 'label' => 'Name', 'class' => ''],
                ['key' => 'permission', 'label' => 'Permissions'],
                ];

                @endphp
                <x-mary-table :headers="$headers" :rows="$roles" with-pagination per-page="perPage1"
                    :per-page-values="[5, 20, 10, 50]">
                    @scope('cell_permission', $rol)
                    @forelse($rol->permissions as $permission)
                    <x-mary-badge :value="$permission->name" class="text-white bg-green-500" />
                    @empty
                    <p class="text-white bg-red-500"> No permission </p>
                    @endforelse
                    @endscope
                    @scope('actions', $role)
                    <nobr>
                        <x-mary-button icon="s-pencil-square" wire:click="update({{ $role->id }})" spinner
                            class="btn-sm" />
                        <x-mary-button icon="o-trash" wire:click="delete({{ $role->id }})"
                            wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                            class="btn-sm" />
                    </nobr>
                    @endscope
                </x-mary-table>
            </x-mary-card>
        </div>
    </div>
    <x-mary-modal wire:model="modalRole" persistent class="backdrop-blur" box-class="h-full max-w-full">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md"
            label="{{ !isset($roleForm->role) ? 'CREAR ROL' : 'EDITAR ROL' }}" />
        <x-mary-form wire:submit.prevent="{{ !isset($roleForm->role) ? 'create' : 'edit' }}">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Nombre" inline wire:model='roleForm.name' />
                    </div>
                </div>
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">
                        @php
                        $headers = [
                        ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
                        ['key' => 'name', 'label' => 'Permiso'],
                        ];
                        @endphp
                        <x-mary-card subtitle="Seleccione los permisos para el rol" shadow separator>
                            <x-slot:menu>
                                <x-mary-input label="permiso" icon="o-magnifying-glass" inline  wire:model.live='search'/>
                            </x-slot:menu>
                            <x-mary-table :headers="$headers" :rows="$permisos" wire:model="selected" selectable selectable
                            selectable-key="name" with-pagination per-page="perPage2"/>
                        </x-mary-card>
                        
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancel" @click="$wire.modalRole = false" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="{{ !isset($roleForm->role) ? 'create' : 'edit' }}"
                        label="Save" class="bg-blue-500" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
</div>