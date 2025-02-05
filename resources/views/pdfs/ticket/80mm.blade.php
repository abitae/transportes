<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ticket->serie }}-{{ $ticket->correlativo }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: -50px 1px -50px -50px;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            width: 340px;
            /* Ampliado el ancho del body */
        }

        .ticket {
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
    </style>
</head>

<body>
    <div class="ticket">
        <!-- Logo y datos de la empresa centrados -->
        <div class="text-center">
            <div class="text-xs">
                <img src="./img/logo_format_ticket.jpg" alt="Infinity" width="200" height="w-auto h-16 mx-auto mb-2" alt="Logo de la Empresa">
                <p class="font-weight-bold">BRAYAN BRUSH CORPORACION LOGISTICO</p>
                <p>R.U.C.: {{ $ticket->company->ruc }}</p>
                <p>{{ $ticket->company->address }}</p>
                <p class="m-0">Telf: {{ $ticket->company->telephone }}</p>
                <p class="m-0">Email: {{ $ticket->company->email }}</p>
            </div>
        </div>
        <!-- Título de la Factura y Número de Serie en un recuadro -->
        <div class="text-center border-top border-dark">
            <h1 class="m-1 text-sm font-weight-bold">TICKET</h1>
            <p class="m-1 text-sm font-weight-bold">{{ $ticket->serie }}</p>
        </div>
        <section class="text-xs text-left border-top border-dark">
            <p>Fecha Emición: {{ $ticket->fechaEmision }}</p>
            <p>Fecha Traslado: {{ $ticket->fecTraslado }}</p>
        </section>
        <!-- Información del Cliente -->
        <section class="text-xs text-left border-top border-dark">
            <p>Razón Social: {{ $ticket->client->name }}</p>
            <p>{{ strtoupper($ticket->client->type_code) }}: {{ $ticket->client->code }}</p>
            <p>Dirección: {{ $ticket->client->address }}</p>
        </section>
        <!-- Detalle de la Factura -->
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
                    @forelse ($ticket->details as $detail)
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
                <span>S/ {{ $ticket->valorVenta }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="font-weight-bold">IGV (18%):</span>
                <span>S/ {{ $ticket->mtoIGV }}</span>
            </div>
            <div class="pt-1 mt-1 d-flex justify-content-between font-weight-bold border-top border-dark">
                <span>Total:</span>
                <span>S/ {{ $ticket->mtoImpVenta }}</span>
            </div>
        </section>
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
            <!-- ...existing policy text... -->
        </footer>
    </div>
</body>

</html>