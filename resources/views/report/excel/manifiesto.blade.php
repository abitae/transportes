<table>
    <tbody>
        <tr>
            <th colspan="5">9/2/2024</th>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>CONDUCTOR
            </th>
            <td>GUMERCINDO LEONCIO VELAZQUE SAVALA
            </td>
            <th>MARCA DEL VEHICULO
            </th>
            <td> HINO
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>DNI
            </th>
            <td>21120418
            </td>
            <th>CONFIGURACION VEHICULAR
            </th>
            <td>N-3
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>PLACA
            </th>
            <td>W7L-874
            </td>
            <th>MTC
            </th>
            <td>1553682
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>LICENCIA
            </th>
            <td>Q21120418
            </td>
            <th>TELEF
            </th>
            <td>1553682
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>NRO GUIA
            </th>
            <th>GUIA CLIENTE
            </th>
            <th>DESTINATARIO</th>
            <th>TELEFONO</th>
            <th>REMITENTE</th>
            <th>CANTIDAD</th>
            <th>PAQUETES</th>
            <th>MONTO</th>
            <th>RETORNO</th>
            <th>PAGO</th>
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
                {{ $packsLibre.''.$paquete->description.'('.$paquete->cantidad.')'.'('.$paquete->amount.')-' }}
                @empty
                @endforelse
            </td>
            <td>
                {{ $encomiendaLibre->monto }}
            </td>
            <td>
                {{ $encomiendaLibre->isReturn ? 'SI' : 'NO' }}
            </td>
            <td>
                {{ $encomiendaLibre->estado_pago = 2 ? 'CONTRA ENTREGA' : 'PAGADO'}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>NRO GUIA</th>
            <th>GUIA CLIENTE</th>
            <th>DESTINATARIO</th>
            <th>TELEFONO</th>
            <th>REMITENTE</th>
            <th>CANTIDAD</th>
            <th>PAQUETES</th>
            <th>MONTO</th>
            <th>RETORNO</th>
            <th>PAGO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($encomiendasIsHome as $encomienda)
        <tr>
            <td>{{ $encomienda->code }}</td>
            <td>{{ $encomienda->doc_traslado ?? 'S/D' }}</td>
            <td>{{ $encomienda->remitente->name }}</td>
            <td>{{ $encomienda->remitente->phone }}</td>
            <td>{{ $encomienda->destinatario->name }}</td>
            <td>{{ $encomienda->cantidad }}</td>
            <td>
                @php
                $packs = '';
                @endphp
                @forelse ($encomienda->paquetes as $paquete)
                {{ $packs.''.$paquete->description.'('.$paquete->cantidad.')'.'('.$paquete->amount.')-' }}
                @empty
                @endforelse
            </td>
            <td>
                {{ $encomienda->monto }}
            </td>
            <td>
                {{ $encomienda->isReturn ? 'SI' : 'NO' }}
            </td>
            <td>
                {{ $encomiendaLibre->estado_pago = 2 ? 'CONTRA ENTREGA' : 'PAGADO'}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

