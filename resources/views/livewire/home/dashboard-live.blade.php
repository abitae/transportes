<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>

        </x-slot:menu>
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
            <div>
                <x-mary-chart wire:model="myChart" />
            </div>
            <div>
                <x-mary-chart wire:model="myLine" />
            </div>
        </div>
    </x-mary-card>
</div>
