@php
  $totalPackages = collect($envios->detalle_envio)->reduce(function ($acc, $item) {
    return $acc + $item->cantidad;
  },0);
@endphp
<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Sticker {{$envios->id_generado}}</title>
</head>
<body style="margin: 0;">
  <style>
    body {
      font-family: Verdana, Arial, Helvetica, sans-serif;
    }
    .titulo {
      font-size: 19px;
    }
    .subtitulo {
      font-size: 9px;
    }
    .width-first {
      width: 90px;
      text-align: right;
    }
    .text-bold {
      font-weight: bold;
    }
  </style>
  <table style="width: 100%">
      <tr>
        <td colspan="2" style="text-align: left;">
          <strong class="titulo">Brayan Bursh</strong>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">
          <strong class="titulo">{{$envios->id_generado}}</strong>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left" class="subtitulo text-bold">CAJAS - ({{$totalPackages}})</td>
      </tr>
      <tr>
        <td class="subtitulo width-first text-bold">Destinatario :</td>
        <td class="subtitulo text-bold">{{ $envios->nombre_destinatario}} </td>
      </tr>
      <tr>
        <td class="subtitulo width-first text-bold">Direccion destino :</td>
        <td class="subtitulo text-bold">{{ $envios->direccion_destino }} </td>
      </tr>
      <tr>
        <td class="subtitulo width-first text-bold">Telefono :</td>
        <td class="subtitulo text-bold">{{ $envios->telefono_destino }} </td>
      </tr>
      <tr>
        <td class="subtitulo width-first text-bold">Fecha de registro :</td>
        <td class="subtitulo text-bold">{{ $date }}</td>
      </tr>
  </table>
</body>
</html>
