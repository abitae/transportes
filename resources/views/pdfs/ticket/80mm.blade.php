<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ticket->serie }}-{{ $ticket->correlativo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                size: auto;
                margin: 0;
            }

            body {
                margin: 0;
            }
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
        }

        .ticket {
            width: 80mm;
            /* Ancho típico de un ticket */
            padding: 1rem;
            margin: auto;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="ticket">
        <!-- Logo y datos de la empresa centrados -->
        <div class="mb-1 text-center">
            <div class="text-xs">
                <img src="{{ env('APP_URL') }}/{{ $ticket->company->logo_path }}" alt="Logo de la Empresa"
                    class="w-auto h-16 mx-auto mb-2">
                <p class="font-semibold">CORPORACION LOGISTICA BRAYAN BRUSH</p>
                <p>R.U.C.: {{ $ticket->company->ruc }}</p>
                <p>{{ $ticket->company->address }}</p>
                <p>Telf: {{ $ticket->company->telephone }}</p>
                <p>Email: {{ $ticket->company->email }}</p>
            </div>
        </div>

        <!-- Título de la Factura y Número de Serie en un recuadro -->
        <div class="mb-1 text-center border-t border-gray-400">
            <h1 class="text-xs font-semibold">TICKET</h1>
            <p class="text-sm font-semibold">{{ $ticket->serie }}</p>
        </div>
        <section class="mb-1 text-xs border-t border-gray-400">
            <p>Fecha Emición: {{ $ticket->fechaEmision }}</p>
            <p>Fecha Traslado: {{ $ticket->fecTraslado }}</p>
        </section>
       
        <!-- Información del Cliente -->
        <section class="mb-1 text-xs border-t border-gray-400">
            <p>Razón Social: {{ $ticket->client->name }}</p>
            <p>{{ strtoupper($ticket->client->type_code) }}: {{ $ticket->client->code }}</p>
            <p>Dirección: {{ $ticket->client->address }}</p>
        </section>

        <!-- Detalle de la Factura -->
        <section class="mb-4">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-2 py-1 text-left border">Descripción</th>
                        <th class="px-2 py-1 text-right border">Cant</th>
                        <th class="px-2 py-1 text-right border">Precio</th>
                        <th class="px-2 py-1 text-right border">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticket->details as $detail)
                    <tr>
                        <td class="px-2 py-1 border">{{ $detail->descripcion }}</td>
                        <td class="px-2 py-1 text-right border">{{ $detail->cantidad }}</td>
                        <td class="px-2 py-1 text-right border">{{ $detail->mtoPrecioUnitario }}</td>
                        <td class="px-2 py-1 text-right border">{{ number_format($detail->mtoPrecioUnitario *
                            $detail->cantidad,2) }}</td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </section>

        <!-- Totales -->
        <section class="mb-4 text-sm">
            <div class="flex justify-between border-t border-gray-400">
                <span class="font-semibold">Gravada:</span>
                <span>S/ {{ $ticket->valorVenta }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">IGV (18%):</span>
                <span>S/ {{ $ticket->mtoIGV }}</span>
            </div>
            <div class="flex justify-between pt-1 mt-1 font-semibold border-t border-gray-400">
                <span>Total:</span>
                <span>S/ {{ $ticket->mtoImpVenta }}</span>
            </div>
        </section>

        <!-- Código QR -->
        <section class="mt-4 text-center">
            <!-- Imagen de ejemplo para el código QR -->
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/500px-Codigo_QR.svg.png?20080824194905"
                alt="Código QR" class="w-16 mx-auto">
        </section>

        <!-- Pie de página -->
        <footer class="mt-4 text-xs text-center">
            <p>Gracias por su compra.</p>

            Políticas de Envío
            <br>
            <span>Corporación Logística Brayan Brush EIRL</span>
            <br>
            • El cliente debe proporcionar una dirección completa y un número de teléfono válido. Si no es posible
            contactar al destinatario o la dirección es incorrecta, el paquete será devuelto a nuestros almacenes.
            • Después de dos intentos fallidos, el envío será devuelto a nuestros almacenes. El cliente deberá coordinar
            el retiro o solicitar un nuevo envío, sujeto a costos adicionales.
            • Si el cliente requiere una entrega fuera del horario de 9 a.m. a 6 p.m., debe coordinarlo previamente.
            Este servicio está sujeto a disponibilidad y costos adicionales.
            • El destinatario puede autorizar a un tercero para recoger la encomienda, siempre que presente su DNI y la
            carta poder correspondiente.
            • El cliente puede optar por retirar su encomienda en un punto de recogida, acelerando el proceso y
            reduciendo riesgos.
            • En los envíos contra entrega, el cliente debe realizar el pago antes de recibir el paquete.
            • Si el envío no se recoge en 30 días, la empresa no se hará responsable. Desde el tercer día, se cobrará 5
            soles por día de almacenamiento.
            • La empresa no verifica el contenido de los envíos. Es responsabilidad del cliente asegurarse de que los
            paquetes estén correctamente empaquetados.
            • Si el paquete llega dañado, debe ser revisado y grabado en el momento de la entrega. La empresa no se hace
            responsable si el daño es por mal embalaje.
            • Si no se recoge un envío con retorno de cargo en 60 días, no habrá regularización pendiente.
            • caso de extravío, se realizará una conciliación con el destinatario.
            • Los reclamos por daños o pérdidas deben presentarse en 3 días hábiles con boleta/factura y la guía de
            remisión.
            • Recuperar el código de envío tiene un costo de 10 soles y puede tomar entre 1 y 24 horas.
            • Se requiere presentar el DNI físico y el código de verificación para retirar el paquete.
            • La empresa no se responsabiliza por retrasos causados por factores externos como clima o bloqueos de
            carreteras.
        </footer>
    </div>
</body>

</html>