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
            <td>{{ $encomienda->transportista->name }}
            </td>
            <th>MARCA DEL VEHICULO
            </th>
            <td> {{ $encomienda->vehiculo->marca }}
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>DNI
            </th>
            <td>{{ $encomienda->transportista->dni }}
            </td>
            <th>CONFIGURACION VEHICULAR
            </th>
            <td>{{ $encomienda->vehiculo->tipo }}
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>PLACA
            </th>
            <td>{{ $encomienda->vehiculo->name }}
            </td>
            <th>MTC
            </th>
            <td>{{ $encomienda->transportista->licencia }}
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>LICENCIA
            </th>
            <td>{{ $encomienda->transportista->licencia }}
            </td>
            <th>TELEF
            </th>
            <td>{{ $encomienda->transportista->tipo }}
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
                {{ $encomiendaLibre->estado_pago}}
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
                {{ $encomienda->estado_pago}}
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
        @foreach($encomiendasIsReturn as $encomiendaReturn)
        <tr>
            <td>{{ $encomiendaReturn->code }}</td>
            <td>{{ $encomiendaReturn->doc_traslado ?? 'S/D' }}</td>
            <td>{{ $encomiendaReturn->remitente->name }}</td>
            <td>{{ $encomiendaReturn->remitente->phone }}</td>
            <td>{{ $encomiendaReturn->destinatario->name }}</td>
            <td>{{ $encomiendaReturn->cantidad }}</td>
            <td>
                @php
                $packs = '';
                @endphp
                @forelse ($encomiendaReturn->paquetes as $paquete)
                {{ $packs.''.$paquete->description.'('.$paquete->cantidad.')'.'('.$paquete->amount.')-' }}
                @empty
                @endforelse
            </td>
            <td>
                {{ $encomiendaReturn->monto }}
            </td>
            <td>
                {{ $encomiendaReturn->isReturn ? 'SI' : 'NO' }}
            </td>
            <td>
                {{ $encomiendaReturn->estado_pago}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>