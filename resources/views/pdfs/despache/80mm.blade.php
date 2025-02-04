<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $despache->serie }}-{{ $despache->correlativo }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: -50px 1px -50px -50px;
            font-family: 'Arial', sans-serif;
            width: 340px;
            /* Ampliado el ancho del body */
        }

        .despache {
            padding: 1rem 1rem 0 1rem;
            /* Eliminado el padding inferior */
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(214, 10, 10, 0.1);
            text-align: center;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .table-sm {
            font-size: 0.6rem;
        }

        p {
            padding: 0;
            margin: 0;
        }

        .cuadrado {
            width: 310px;
            height: 0;
            padding-top: 25%;
            position: relative;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="despache">
        <!-- Logo y datos de la empresa centrados -->
        <div class="text-center">
            <div class="text-xs">
                <img src="./img/logo_format_ticket.jpg" alt="Infinity" width="200" height="w-auto h-16 mx-auto mb-2"
                    alt="Logo de la Empresa">
                <p class="font-weight-bold">BRAYAN BRUSH CORPORACION LOGISTICO</p>
                <p>R.U.C.: {{ $despache->company->ruc }}</p>
                <p>{{ $despache->company->address }}</p>
                <p class="m-0">Telf: {{ $despache->company->telephone }}</p>
                <p class="m-0">Email: {{ $despache->company->email }}</p>
                <P>N°Reg.MTC : 1553682 CNG</P>
            </div>
        </div>
        <!-- Título de la Factura y Número de Serie en un recuadro -->
        <div class="text-center border-top border-dark">
            <h1 class="m-1 text-sm font-weight-bold">GUIA TRANSPORTISTA</h1>
            <p class="m-1 text-sm font-weight-bold">{{ $despache->serie }} - {{ $despache->correlativo }}</p>
        </div>
        <section class="text-xs text-left border-top border-dark">
            <p>Fecha Emición: {{ $despache->fechaEmision }}</p>
            <p>Fecha Traslado: {{ $despache->fecTraslado }}</p>
        </section>
        <!-- Información del Cliente -->
        <section class="text-xs text-left border-top border-dark">
            <p class="font-semibold">DATOS REMITENTE</p>
            <p>{{ strtoupper($despache->remitente->type_code) }}: {{ $despache->remitente->code }}</p>
            <p>{{ $despache->remitente->name }}</p>
            <p>{{ $despache->remitente->address }}</p>
            <p>Tel:{{ $despache->remitente->phone }}</p>
        </section>
        <section class="text-xs text-left border-top border-dark">
            <p class="font-semibold">DATOS DESTINATARIO</p>
            <p>{{ strtoupper($despache->destinatario->type_code) }}: {{ $despache->destinatario->code }}</p>
            <p>{{ $despache->destinatario->name }}</p>
            <p>{{ $despache->destinatario->address }}</p>
            <p>Tel:{{ $despache->destinatario->phone }}</p>
            <!-- Detalle de la Factura -->
            <section class="text-xs text-left border-top border-dark">
                <p>Origen:{{ $despache->encomienda->sucursal_remitente->address }}</p>
                <p>Destino:{{ $despache->encomienda->sucursal_destinatario->address }}</p>
            </section>
            <section class="text-xs text-left border-b border-top border-dark">
                <p class="font-semibold">ENTREGA</p>
                @if ($despache->isHome)
                <p>{{ $despache->destinatario->address }}</p>
                @else
                <p>RECOJO EN AGENCIA</p>
                @endif

            </section>
            <section class="text-xs text-left border-top border-dark">
                <p class="font-semibold">FORMA DE PAGO</p>
                <p>{{ $despache->encomienda->estado_pago }}</p>
            </section>
            <section class="mb-4">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="bg-light">
                            <th class="px-2 py-1 text-left">Descripción</th>
                            <th class="px-2 py-1 text-right">Cant</th>
                            <th class="px-2 py-1 text-right">Precio</th>
                            <th class="px-2 py-1 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($despache->details as $detail)
                        <tr>
                            <td class="px-2 py-1 text-left">{{ $detail->descripcion }}</td>
                            <td class="px-2 py-1 text-right">{{ $detail->cantidad }}</td>
                            <td class="px-2 py-1 text-right">{{ $detail->mtoPrecioUnitario }}</td>
                            <td class="px-2 py-1 text-right">{{ number_format($detail->mtoPrecioUnitario *
                                $detail->cantidad,2) }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </section>
            <!-- Totales -->
            <section class="mb-4 text-sm text-right">
                <div class="d-flex justify-content-between border-top border-dark">
                    <span class="font-weight-bold">Gravada:</span>
                    <span>S/ {{ $despache->valorVenta }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">IGV (18%):</span>
                    <span>S/ {{ $despache->mtoIGV }}</span>
                </div>
                <div class="pt-1 mt-1 d-flex justify-content-between font-weight-bold border-top border-dark">
                    <span>Total:</span>
                    <span>S/ {{ $despache->mtoImpVenta }}</span>
                </div>
            </section>
            <div class="cuadrado">
                <p class="text-xs">FIRMA</p>

            </div>
            <!-- Código QR -->
            <section class="mt-4 text-center">
                <!-- Imagen de ejemplo para el código QR -->
                <div class="d-flex justify-content-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/500px-Codigo_QR.svg.png?20080824194905"
                        alt="Código QR" style="width: 100px;">
                </div>
            </section>
            <!-- Pie de página -->
            <footer class="mt-4 text-xs text-center">
                <p>Gracias por su compra.</p>
                Políticas de Envío
                <br>
                <span>Corporación Logística Brayan Brush EIRL</span>
                <br>
                <section class="text-xs text-left border-top border-dark">
                    <p>• El cliente debe proporcionar una dirección completa y un número de teléfono válido. Si no es posible contactar al destinatario o la dirección es incorrecta, el paquete será devuelto a nuestros almacenes.</p>
                    <p>• Después de dos intentos fallidos, el envío será devuelto a nuestros almacenes. El cliente deberá coordinar el retiro o solicitar un nuevo envío, sujeto a costos adicionales.</p>
                    <p>• Si el cliente requiere una entrega fuera del horario de 9 a.m. a 6 p.m., debe coordinarlo previamente. Este servicio está sujeto a disponibilidad y costos adicionales.</p>
                    <p>• El destinatario puede autorizar a un tercero para recoger la encomienda, siempre que presente su DNI y la carta poder correspondiente.</p>
                    <p>• El cliente puede optar por retirar su encomienda en un punto de recogida, acelerando el proceso y reduciendo riesgos.</p>
                    <p>• En los envíos contra entrega, el cliente debe realizar el pago antes de recibir el paquete.</p>
                    <p>• Si el envío no se recoge en 30 días, la empresa no se hará responsable. Desde el tercer día, se cobrará 5 soles por día de almacenamiento.</p>
                    <p>• La empresa no verifica el contenido de los envíos. Es responsabilidad del cliente asegurarse de que los paquetes estén correctamente empaquetados.</p>
                    <p>• Si el paquete llega dañado, debe ser revisado y grabado en el momento de la entrega. La empresa no se hace responsable si el daño es por mal embalaje.</p>
                    <p>• Si no se recoge un envío con retorno de cargo en 60 días, no habrá regularización pendiente.</p>
                    <p>• En caso de extravío, se realizará una conciliación con el destinatario.</p>
                    <p>• Los reclamos por daños o pérdidas deben presentarse en 3 días hábiles con boleta/factura y la guía de remisión.</p>
                    <p>• Recuperar el código de envío tiene un costo de 10 soles y puede tomar entre 1 y 24 horas.</p>
                    <p>• Se requiere presentar el DNI físico y el código de verificación para retirar el paquete.</p>
                    <p>• La empresa no se responsabiliza por retrasos causados por factores externos como clima o bloqueos de carreteras.</p>
                </section>
            </footer>
    </div>
</body>

</html>