<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>


        </x-slot:menu>
        @php
        $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-green-500 w-1'],
        ['key' => 'document', 'label' => 'Documento', 'class' => ''],
        ['key' => 'fecha', 'label' => 'Fecha documento', 'class' => ''],
        ['key' => 'cliente', 'label' => 'Cliente', 'class' => ''],
        ['key' => 'mtoImpVenta', 'label' => 'Monto', 'class' => ''],
        ['key' => 'pdf_a4', 'label' => 'PDF A4', 'class' => ''],
        ['key' => 'pdf_ticket', 'label' => 'PDF TICKET', 'class' => ''],
        ['key' => 'option', 'label' => 'Opciones', 'class' => ''],
        ];
        @endphp
        <x-mary-table :headers="$headers" :rows="$tickets" striped with-pagination per-page="perPage"
            :per-page-values="[5, 20, 10, 50]">
            @scope('cell_document', $stuff)
            <x-mary-badge :value="$stuff->correlativo" class="badge-primary" />
            @endscope
            @scope('cell_fecha', $stuff)
            {{ $stuff->created_at->format('d-m-Y H:i A') }}
            @endscope
            @scope('cell_cliente', $stuff)
            {{ $stuff->client->code }}
            <br>
            {{ $stuff->client->name }}
            @endscope
            @scope('cell_pdf_a4', $stuff)
            <x-mary-button icon="o-document-chart-bar" target="_blank" no-wire-navigate link="/ticket/a4/{{ $stuff->id }}" spinner
                class="text-white bg-purple-500 btn-xs" />
            @endscope
            @scope('cell_pdf_ticket', $stuff)
            <x-mary-button icon="o-ticket" target="_blank" no-wire-navigate link="/ticket/80mm/{{ $stuff->id }}" spinner
                class="text-white bg-green-500 btn-xs" />
            @endscope
        </x-mary-table>
    </x-mary-card>
</div>