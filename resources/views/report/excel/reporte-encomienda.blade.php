<table>
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>GUIA CLIENTE</th>
            <th>DESTINATARIO</th>
            <th>TELEFONO</th>
            <th>REMITENTE</th>
            <th>CANTIDAD</th>
            <th>PAQUETES</th>
            <th>MONTO</th>
            <th>RETORNO</th>
            <th>TIPO ENVIO</th>
            <th>CREDITO</th>
            <th>DOCUMENTO</th>
            <th>ESTADO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($encomiendas as $encomiendaLibre)
                <tr>
                    <td>{{ $encomiendaLibre->code }}</td>
                    <td>{{ $encomiendaLibre->doc_traslado ?? 'S/D' }}</td>
                    <td>{{ $encomiendaLibre->remitente->name }}</td>
                    <td>{{ $encomiendaLibre->remitente->phone }}</td>
                    <td>{{ $encomiendaLibre->destinatario->name }}</td>
                    <td>{{ $encomiendaLibre->cantidad }}</td>
                    <td>
                        @php
                            $packsLibre = '';
                        @endphp
                        @forelse ($encomiendaLibre->paquetes as $paquete)
                            {{ $packsLibre . '' . $paquete->description . '(' . $paquete->cantidad . ')' . '(' . $paquete->amount . ')-' }}
                        @empty
                        @endforelse
                    </td>
                    <td>{{ $encomiendaLibre->monto }}</td>
                    <td>{{ $encomiendaLibre->isReturn ? 'SI' : 'NO' }}</td>
                    <td>{{ $encomiendaLibre->estado_pago}}</td>
                    <td>{{ $encomiendaLibre->tipo_pago }}</td>
                    <td>{{ $encomiendaLibre->tipo_comprobante }}</td>
                    <td>{{ $encomiendaLibre->estado_cretido ?? 'incompleto' }}</td>
                </tr>
        @endforeach
    </tbody>
</table>