
@php
  function convertImageBase64($image){
    $pathImage = public_path()."\img/".$image;
    $arrContextOptions = array(
      "ssl" => array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
      ),
    );
    $path = $pathImage;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
  }
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Rótulo - Brayan Brush</title>

  <style>
    @media print{@page {size: landscape}}
    *{
      margin: 0;
      padding: 0;
      font-family: fantasy, system-ui;
      box-sizing: border-box;
    }
    table {
      width: 100%;
      font-size: 2rem;
      box-sizing: border-box;
      border-collapse: collapse;
    }
  </style>
</head>
<body style="padding: 1rem;">
  <table style="border: 1px solid gray;">
    <tr>
      <td style="padding: 1rem;"><h2 style="text-align: center">FRÁGIL</h2></td>
    </tr>
    <tr><td style="background-color:gray; height: 1px"></td></tr>
    <tr>
      <td>
        <table>
          <tbody>
            <tr style="border-bottom: 1px solid gray;">
              <td style="padding: 1.5rem 1rem;">
                <h2>ORIGEN:</h2>
              </td>
              <td style="padding: 1.5rem 1rem;">
                <h2>DESTINO:</h2>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr style="border-bottom: 1px solid gray;">
      <td>
        <table>
          <tr><td colspan="2" style="background-color:gray; height: 1px"></td></tr>
          <tr>
            <td style="padding: .5rem;" colspan="2"><h2>DESTINATARIO:</h2></td>
          </tr>
          <tr>
            <td style="padding: .5rem 2rem; font-family: system-ui;" colspan="2">NOMBRE COMPLETO: __________________________________________</td>
          </tr>
          <tr>
            <td style="padding: .5rem 2rem; font-family: system-ui;">DNI: __________________________</td>
            <td style="padding: .5rem 2rem; font-family: system-ui;">RUC: _____________________</td>
          </tr>
          <tr>
            <td style="padding: .5rem 2rem; font-family: system-ui;">Cel.: __________________________</td>
          </tr>
          <tr>
            <td style="padding: .5rem 2rem; font-family: system-ui;" colspan="2"> <img src="{{ convertImageBase64('square.png') }}" alt="">&nbsp;Envio a domicilio: _____________________________________________</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr><td style="background-color:gray; height: 1px"></td></tr>
    <tr style="border-bottom: 1px solid gray;">
      <td style="padding: 1.5rem 1rem;">
        <h2>N° DE GUÍA:</h2>
      </td>
    </tr>
    <tr><td style="background-color:gray; height: 1px"></td></tr>
    <tr style="background-color: #B8B8B8;">
      <td style="padding: .5rem 1rem;">
        <table>
          <tbody>
            <tr>
              <td><img style="border-radius: 6px;height: 60px;" src="{{ convertImageBase64('rotulo.jpg') }}" alt=""></td>
              <td style="text-align: right"><img style="border-radius: 6px;height: 82px;" src="{{ convertImageBase64('logo-white.png') }}" alt=""></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
