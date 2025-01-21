<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-toggle label="Produccion" wire:model.live="companyForm.production" />
            <hr />
            <x-mary-button wire:click='save' responsive label="Guardar" class="text-white bg-sky-500" />
        </x-slot:menu>
        <div class="grid grid-cols-2 grid-rows-6 gap-1">
            <x-mary-input label="Numero de documento" wire:model='companyForm.ruc' />
            <x-mary-input label="Razon Social" wire:model='companyForm.razonSocial' />
            <div class="col-span-2">
                <x-mary-input label="Direccion" wire:model='companyForm.address' />
            </div>
            <x-mary-input label="Email" wire:model='companyForm.email' />
            <x-mary-input label="Telefono" wire:model='companyForm.telephone' />
            <x-mary-input label="sol_user" wire:model='companyForm.sol_user' />
            <x-mary-input type='password' label="sol_pass" wire:model='companyForm.sol_pass' />
            <x-mary-input label="client_id" wire:model='companyForm.client_id' />
            <x-mary-input type='password' label="client_secret" wire:model='companyForm.client_secret' />
        </div>
        <x-mary-icon name="o-envelope" class="w-12 h-12 p-2 text-white bg-orange-500 rounded-full" />
        <x-mary-form wire:submit="saveArchive" separator>
            <div class="col-span-2">
                <x-mary-file wire:model="certificado" label="Certificado" />
            </div>
            <div class="col-span-2">
                <x-mary-file wire:model="logo" label="Logo" />
            </div>
            <x-slot:actions>
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="saveArchive" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>