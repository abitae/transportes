<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Sticker {{$encomienda->code}}</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="m-0">
  <style>
    .container {
      width: 100%;
      height: 100%;
      padding: 0;
      margin: 0;
    }
    .titulo {
      font-size: 20px;
    }
  </style>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <strong class="titulo">Brayan Bursh</strong>
        <strong class="titulo">{{$encomienda->code}}</strong>
        CAJAS - ({{$encomienda->cantidad}})
      </div>
      <div class="col-md-6">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/500px-Codigo_QR.svg.png?20080824194905"
        alt="Código QR" style="width: 100px;">
      </div>
    </div>

  </div>
</body>
</html>
