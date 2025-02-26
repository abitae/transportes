<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            <x-mary-button wire:click="switch" icon="s-eye" label="History"
                class="text-white bg-purple-500" responsive spinner />
        </x-slot:menu>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <x-mary-chart wire:model="myChart" />
            </div>

            <div>
                <x-mary-chart wire:model="myLine" />
            </div>

        </div>
    </x-mary-card>

</div>