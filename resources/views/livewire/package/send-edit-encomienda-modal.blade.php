<x-mary-modal wire:model="editEncomiendaModal" class="backdrop-blur" title="Hello" subtitle="Livewire example"
    box-class="max-h-full max-w-128 sm:max-w-md md:max-w-lg lg:max-w-2xl">
    <div>Hey!</div>

    <x-slot:actions>
        <x-mary-button label="Cancel" @click="$wire.editEncomiendaModal = false" />
        <x-mary-button label="Confirm" class="btn-primary" />
    </x-slot:actions>
</x-mary-modal>
