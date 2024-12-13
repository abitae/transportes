<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $despache->serie }}-{{ $despache->correlativo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .page {
            padding: 1cm;
            height: 297mm;
            width: 210mm;
            margin: auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .bordered-box {
            border: 1px solid #000;
            padding: 1rem;
            /* Doble del tamaño original */
            text-align: center;
            width: 300px;
            /* Ancho fijo para mantener el diseño */
        }
    </style>
</head>

<body>
    <div class="bg-white page">
        <!-- Header -->
        <header class="mb-2">
            <div class="flex items-center justify-between">
                <!-- Logo y datos de la empresa -->
                <div class="flex items-center">
                    <div class="text-xs text-center">
                        <img src="{{ env('APP_URL') }}/{{ $despache->company->logo_path }}" alt="Logo" class="w-48 h-18">
                        <p>{{ $despache->company->address }}</p>
                        <p>Email:{{ $despache->company->email }}- Telf: {{ $despache->company->telephone }}</p>
                    </div>
                </div>
                <!-- Título de la Factura, Serie y Correlativo en un recuadro -->
                <div class="bordered-box">
                    <h1 class="text-lg">R.U.C. {{ $despache->company->ruc }}</h1>
                    <h1 class="text-lg font-semibold">{{ $despache->tipoDoc ? 'FACTURA ELECTRONICA' : 'BOLETA
                        ELECTRONICA' }}</h1>
                    <p class="text-md">{{ $despache->serie }}-{{ $despache->correlativo }}</p>
                </div>
            </div>
        </header>
        <!-- Información del Cliente -->
        <section class="mb-1">
            <div class="text-sm text-left">
                <p>Razón Social: {{ $despache->client->name }}</p>
                <p>{{ strtoupper($despache->client->type_code) }}: {{ $despache->client->code }}</p>
                <p>Dirección: {{ $despache->client->address }}</p> 
            </div>
        </section>

        <!-- Detalle de la Factura -->
        <section class="mb-2">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-2 py-1 text-left border">Descripción</th>
                        <th class="px-2 py-1 text-right border">Cantidad</th>
                        <th class="px-2 py-1 text-right border">Precio Unitario (S/.)</th>
                        <th class="px-2 py-1 text-right border">Total (S/.)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($despache->details as $detail)
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
        <section class="mt-4">
            <div class="flex justify-end">
                <div class="w-1/3">
                    <div class="flex justify-between border-t border-gray-400">
                        <span class="font-semibold">Gravada:</span>
                        <span>S/ {{ $despache->valorVenta }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">IGV (18%):</span>
                        <span>S/ {{ $despache->mtoIGV }}</span>
                    </div>
                    <div class="flex justify-between pt-2 mt-2 font-semibold border-t border-gray-400">
                        <span>TOTAL:</span>
                        <span>S/ {{ $despache->mtoImpVenta }}</span>
                    </div>
                </div>
            </div>
        </section>
        <!-- Código QR -->
        <section class="mt-6">
            <!-- Imagen de ejemplo para el código QR -->
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/500px-Codigo_QR.svg.png?20080824194905" alt="Código QR" class="w-32 mx-auto">
        </section>
        <!-- Pie de página -->
        <footer class="mt-6 text-xs text-center">
            <p>Gracias por su compra.</p>
            <p>Esta factura ha sido generada según las normas peruanas.</p>
        </footer>
    </div>
</body>

</html>