<!doctype html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Sticker {{$encomienda->code}}</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      font-family: Verdana, Arial, Helvetica, sans-serif;
      border: 1px solid black; /* Agregar borde al body */
    }
    .titulo {
      font-size: 20px;
    }
    .subtitulo {
      font-size: 16px;
      margin: 0;
    }
    .text-bold {
      font-weight: bold;
    }
    .qr-container {
      position: absolute;
      bottom: 0;
      right: 50px;
      margin: 10px;
    }
  </style>
</head>

<body class="m-2">
  <div class="container position-relative">
    <div class="row">
      <div class="col-12">
        <strong class="titulo">BRAYAN BRUSH CORPORACION LOGISTICO</strong>
      </div>
      <div class="col-12">
        <strong class="titulo">{{$encomienda->code}}</strong>
      </div>
      <div class="col-12 subtitulo text-bold">
        CAJAS - ({{$encomienda->cantidad}})
      </div>
    </div>
    <div class="row">
      <div class="col-12 border-top border-dark">
        <strong>REMITENTE</strong>
        <p class="subtitulo">{{$encomienda->remitente->name}}</p>
        <div class="subtitulo">{{ $encomienda->remitente->code }}</div>
        <div class="subtitulo">{{ $encomienda->remitente->address }}</div>
        <p class="subtitulo">sucursal: {{$encomienda->sucursal_destinatario->name}}</p>
      </div>
      <div class="col-12 border-top border-dark">
        <strong>DESTINATARIO</strong>
        <p class="subtitulo">{{$encomienda->destinatario->name}}</p>
        <div class="subtitulo">{{ $encomienda->destinatario->code }}</div>
        <div class="subtitulo">{{ $encomienda->destinatario->address }}</div>
        <p class="subtitulo">sucursal: {{$encomienda->sucursal_remitente->name}}</p>
      </div>
    </div>
    <div class="qr-container">
      <img class="h-16" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/500px-Codigo_QR.svg.png?20080824194905"
        alt="Código QR" style="width: 150px;">
    </div>
  </div>
</body>

</html>