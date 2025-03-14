@isset($manifiesto)
<x-mary-modal wire:model.live="modalFinal" persistent class="backdrop-blur" box-class="w-full">
    <x-mary-card shadow>
        <div class="grid grid-cols-1 gap-0 border-sky-500">
            <div>
                <x-mary-button icon="o-document-arrow-down" target="_blank"
                    wire:click="excelGenerate({{ $manifiesto->id }})" no-wire-navigate spinner
                    class="text-white bg-orange-500 btn-xs" />
            </div>
        </div>
    </x-mary-card>
</x-mary-modal>
@endisset