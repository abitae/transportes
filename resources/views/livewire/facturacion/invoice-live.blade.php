<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            <x-mary-button icon="o-document-chart-bar" wire:click="refresh" spinner class="text-white bg-blue-500 btn-xs" />  
        </x-slot:menu>
        @php
        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-green-500 w-1 text-white'],
            ['key' => 'document', 'label' => 'Documento', 'class' => ''],
            ['key' => 'cliente', 'label' => 'Cliente', 'class' => ''],
            ['key' => 'mtoImpVenta', 'label' => 'Monto', 'class' => ''],
            ['key' => 'pdf', 'label' => 'PDF A4', 'class' => ''],
            ['key' => 'xml', 'label' => 'XML', 'class' => ''],
            ['key' => 'cdr', 'label' => 'CDR', 'class' => ''],
        ];
        @endphp
        <x-mary-table :headers="$headers" :rows="$invoices" striped with-pagination per-page="perPage"
            :per-page-values="[5, 20, 10, 50]">
            @scope('cell_document', $stuff)
            @php
            $valor = $stuff->serie.'-'.$stuff->correlativo;
            @endphp
            <x-mary-badge :value="$valor" class="bg-cyan-500" />
            <br>
            <div class="text-xs">{{ $stuff->created_at->format('d-m-Y H:i A') }}</div>
            @endscope

            @scope('cell_cliente', $stuff)
            <div class="text-xs">{{ $stuff->client->code }}</div>
            <div class="text-xs">{{ $stuff->client->name }}</div>
            @endscope

            @scope('cell_mtoImpVenta', $stuff)
            <div class="text-xs">S/{{ $stuff->mtoImpVenta }}</div>
            @endscope

            @scope('cell_pdf', $stuff)
            <x-mary-button icon="o-document-chart-bar" target="_blank" no-wire-navigate
                link="/invoice/a4/{{ $stuff->id }}" spinner class="text-white bg-purple-500 btn-xs" />
            <x-mary-button icon="o-ticket" target="_blank" no-wire-navigate link="/invoice/80mm/{{ $stuff->id }}"
                spinner class="text-white bg-green-500 btn-xs" />
            @endscope

            @scope('cell_xml', $stuff)
            @if ($stuff->xml_path && $stuff->xml_hash)
            <x-mary-button icon="o-document-arrow-down" target="_blank" wire:click="xmlDownload({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-cyan-500 btn-xs" />
            @else
            <x-mary-button icon="o-arrow-path" target="_blank" wire:click="xmlGenerate({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-orange-500 btn-xs" />
            @endif
            @endscope

            @scope('cell_cdr', $stuff)
            @if ($stuff->cdr_path)
            <x-mary-button icon="o-document-arrow-down" target="_blank" wire:click="downloadCdrFile({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-blue-500 btn-xs" />
            @else
            <x-mary-button icon="o-arrow-path" target="_blank" wire:click="sendXmlFile({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-orange-500 btn-xs" />
            @endif
            @endscope
        </x-mary-table>
    </x-mary-card>
</div>