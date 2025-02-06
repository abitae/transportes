<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo usuario"
                class="text-white bg-sky-500" />
        </x-slot:menu>
    </x-mary-card>
    <div class="grid grid-cols-4 space-x-2">
        <div class="grid col-span-4 pt-2">
            <x-mary-card shadow separator>
                @php
                    $headers = [
                        ['key' => 'id', 'label' => '#', 'class' => 'bg-purple-500 w-1'],
                        ['key' => 'name', 'label' => 'Name', 'class' => ''],
                        ['key' => 'role', 'label' => 'Rol', 'class' => ''],
                        ['key' => 'email', 'label' => 'Email', 'class' => ''],
                        ['key' => 'isActive', 'label' => 'isActive', 'class' => ''],
                    ];
                    $row_decoration = [
                        'bg-red-50' => fn(App\Models\User $user) => !$user->isActive,
                    ];
                @endphp
                <x-mary-table :headers="$headers" :rows="$users" with-pagination per-page="perPage" :row-decoration="$row_decoration"
                    :per-page-values="[5, 20, 10, 50]" striped>
                    @scope('cell_role', $stuff)
                        <span class="text-sm">{{ $stuff->getRoleNames()->first() }}</span>
                    @endscope
                    @scope('cell_isActive', $stuff)
                        <button wire:click='estado({{ $stuff->id }})'
                            wire:confirm.prompt="Estas seguro de eliminar registro?\n\nEscriba 'SI' para confirmar!|SI"
                            class="flex items-center">
                            <div
                                class="h-2.5 w-2.5 rounded-full {{ $stuff->isActive ? 'bg-green-400' : 'bg-red-600' }} mr-2">
                            </div>
                            {{ $stuff->isActive ? 'Active' : 'Disabled' }}
                        </button>
                    @endscope
                    @scope('actions', $user)
                        <nobr>
                            <x-mary-button icon="s-pencil-square" wire:click="edit({{ $user->id }})" spinner
                                class="btn-sm" />
                            <x-mary-button icon="o-trash" wire:click="edit({{ $user->id }})"
                                wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                                class="btn-sm" />
                        </nobr>
                    @endscope
                </x-mary-table>
            </x-mary-card>
        </div>
    </div>
    <x-mary-modal wire:model="modalUser" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md"
            label="{{ !isset($userForm->user) ? 'CREAR USUARIO' : 'EDITAR USUARIO' }}" />
        <x-mary-form wire:submit.prevent="{{ !isset($userForm->user) ? 'create' : 'update' }}">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Nombre" inline wire:model='userForm.name' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Email" inline wire:model='userForm.email' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-select label="" :options="$sucursals" option-value="id"
                            option-label="name" placeholder="Select sucursal" placeholder-value="0"
                            hint="Seleccione una sucursal." wire:model="userForm.sucursal_id" />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-select label="" :options="$roles" option-value="name"
                            option-label="name" placeholder="Select rol" placeholder-value="0"
                            hint="Seleccione un rol." wire:model="userForm.role" />
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancel" wire:click="openModal()" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="{{ !isset($userForm->sucursal) ? 'create' : 'edit' }}"
                        label="Save" class="bg-blue-500" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
</div>
