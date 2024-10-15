<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            <x-mary-button wire:click="switch" icon="s-eye" label="History"
                class="text-white bg-purple-500" responsive spinner />
        </x-slot:menu>
        <div class="grid grid-cols-2 grid-rows-2 gap-1">
            <div>
                <x-mary-chart wire:model="myChart" />
            </div>
            <div>
                <x-mary-chart wire:model="myChart" />
            </div>
            <div class="row-start-2">

            </div>
            <div class="row-start-2">

            </div>
        </div>
    </x-mary-card>

</div>