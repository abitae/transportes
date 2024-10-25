<!doctype html>
<html lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Ticket - 312312313</title>
  
  <style>
    html {
      margin: 5pt 10pt;
    }

    body {
      padding: 0;
      margin-left: 0;
      width: 250px;
      max-width: 250px;
    }

    table {
      border-top: 1px solid black;
      border-collapse: collapse;
      margin: 0px;
    }
    .titulo {
      font-size: 14px;
    }
    .subtitulo {
      font-size: 10px;
    }

    table tbody th {
      text-align: left;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>

<body>

  @php
  $total = 0;

  function convertImageBase64($image){
  $pathImage = public_path()."/img/".$image;
  $arrContextOptions = array(
  "ssl" => array (
  "verify_peer" => false,
  "verify_peer_name" => false,
  ),
  );
  $path = $pathImage;
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
  $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
  return $base64;
  }
  @endphp
  <table>
    <tbody>
      <tr>
        <td colspan="2" class="text-center"> <img src="{{ convertImageBase64("logo_format_ticket.jpg") }}"
            style="height: 90px;"> </td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center">{{ $envio->tipo_comprobante }}</th>
      </tr>
      <tr>
        <th colspan="2" class="text-center titulo"> Guía Elect: {{ $envio->code}} </th>
      </tr>
      <tr>
        <th colspan="2" class="text-center titulo"> Doc. Traslado: {{ $envio->doc_traslado ?? ''}} </th>
      </tr>

      <tr>
        <td class="text-center titulo" colspan="2">Brayan Brush E.I.R.L</td>
      </tr>

      <tr>
        <td class="text-center titulo" colspan="2">Jr. Los Obreros 125 - La Victoria Lima La Victoria - Lima. </td>
      </tr>

      <tr>
        <td colspan="2" class="text-center titulo"> <b>RUC: 20568031734</b> </td>
      </tr>

      <tr>
        <td colspan="2" class="text-center titulo"> Central Telefónica: +51 970 795 188 </td>
      </tr>

      <tr>
        <td colspan="2" class="text-center titulo"> WhatsApp: +51 970 795 188</td>
      </tr>

      <tr>
        <td colspan="2" class="text-center subtitulo"> DATOS GUIA DE REMISION - TRANSPORTISTA</td>
      </tr>

      <tr>
        <td colspan="2" class="text-center subtitulo"> N° REGISTRO MTC - <b> {{$envio->colaborador[0]->mtc ?? ''}}</b>
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo"> Fecha Emisión: {{
          \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d'); }} </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo"> Fecha Traslado: {{ $envio->fecha }} </td>
      </tr>

      <tr>
        <td>

        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Origen: </b>{{ $envio->sucursal_remitente->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Destino: </b>{{ $envio->sucursal_destinatario->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="titulo">
          <b>DATOS DEL REMITENTE: </b>
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Nombre/Raz. Social: </b> {{ $envio->remitente->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>DNI/RUC: </b> {{ $envio->remitente->code }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="titulo">
          <b>DATOS DEL DESTINATARIO: </b>
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Nombre/Raz. Social: </b> {{ $envio->destinatario->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>{{ $envio->destinatario->type_code }}: </b> {{ $envio->destinatario->code }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Dirección: </b> {{ $envio->destinatario->address }}
        </td>
      </tr>
      <tr>
        <td colspan="2" class="subtitulo">
          <b>Teléfono: </b> {{ $envio->destinatario->phone }}
        </td>
      </tr>
    </tbody>
  </table>

  <table>
    <tbody class="subtitulo">
      <tr>
        <th colspan="2" class="text-center subtitulo" style="font-size: 10px">
          DATOS DE LA UNIDAD DE TRANSPORTE Y CONDUCTOR
        </th>
      </tr>
      <tr>
        <td colspan="2">
          <b>Placa N°: </b> {{ $envio->vehiculo->placa }}
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <b>DNI: </b> {{$envio->transportista->dni }}
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <b>Nombres :</b> {{$envio->transportista->name}}
        </td>
      </tr>
      <tr>
        <td colspan="2"> Firma: </td>
      </tr>
    </tbody>
  </table>

  <table style="margin-top: 10px;" class="subtitulo">
    <tbody>
      <tr>
        <th colspan="4">
          DESCRIPCIÓN DEL EMBALAJE
        </th>
      </tr>
      <tr>
        <th>Descripcion</th>
        <th>Cantidad</th>
        <th>Unitario</th>
        <th>Sub Total</th>
      </tr>
      @foreach($envio->paquetes as $detalle)
      <?php
          $total += $detalle->amount * $detalle->cantidad;
          $subTotal = $detalle->amount * $detalle->cantidad;
        ?>
      <tr>
        <td>{{$detalle->description}}</td>
        <td>{{$detalle->cantidad}}</td>
        <td>{{$detalle->amount}}</td>
        <td>{{number_format($subTotal,2)}}</td>
      </tr>
      @endforeach
      <tr>
        <td style="text-align: right;" colspan="2">TOTAL:</td>
        <td style="text-align: right;" colspan="2">S/. {{number_format($total,2)}}</td>
      </tr>
    </tbody>
  </table>

</body>

</html>