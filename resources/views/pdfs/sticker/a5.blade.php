<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Perú</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            padding: 1.5cm;
            height: 297mm;
            width: 210mm;
            margin: auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .bordered-box {
            border: 1px solid #000;
            padding: 2rem;
            /* Doble del tamaño original */
            text-align: center;
            width: 250px;
            /* Ancho fijo para mantener el diseño */
        }
    </style>
</head>

<body>
    <div class="bg-white page">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex items-center justify-between">
                <!-- Logo y datos de la empresa -->
                <div class="flex items-center">
                    <div class="text-sm">
                        <img src="https://via.placeholder.com/150x100.png?text=Logo" alt="Logo de la Empresa"
                            class="w-auto mr-4 h-18">
                        <p>Dirección: Av. Principal 456, Lima, Perú</p>
                        <p>Teléfono: (01) 123-4567</p>
                        <p>Email: contacto@xyz.com</p>
                    </div>
                </div>
                <!-- Título de la Factura, Serie y Correlativo en un recuadro -->
                <div class="bordered-box">
                    <h1 class="text-lg font-bold">R.U.C. 20541528092</h1>
                    <h1 class="text-2xl font-bold">FACTURA</h1>
                    <p class="text-md">F001-123456</p>
                </div>
            </div>
        </header>

        <!-- Información del Cliente -->
        <section class="mb-2">
            <div class="text-sm text-left">
                <p>Razón Social: UNIVERSIDAD CONTINENTAL SOCIEDAD ANONIMA CERRADA</p>
                <p>RUC: 12345678</p>
                <p>Dirección: AV. SAN CARLOS NRO. 1980 SAN ANTONIO JUNíN - HUANCAYO - HUANCAYO Huancayo - Huancayo -
                    Junín</p>
            </div>
        </section>

        <!-- Detalle de la Factura -->
        <section class="mb-2">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-2 py-1 text-left border">#</th>
                        <th class="px-2 py-1 text-left border">Descripción</th>
                        <th class="px-2 py-1 text-right border">Cantidad</th>
                        <th class="px-2 py-1 text-right border">Precio Unitario (S/.)</th>
                        <th class="px-2 py-1 text-right border">Total (S/.)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-2 py-1 border">1</td>
                        <td class="px-2 py-1 border">Producto A</td>
                        <td class="px-2 py-1 text-right border">2</td>
                        <td class="px-2 py-1 text-right border">50.00</td>
                        <td class="px-2 py-1 text-right border">100.00</td>
                    </tr>
                    <tr>
                        <td class="px-2 py-1 border">2</td>
                        <td class="px-2 py-1 border">Servicio B</td>
                        <td class="px-2 py-1 text-right border">1</td>
                        <td class="px-2 py-1 text-right border">150.00</td>
                        <td class="px-2 py-1 text-right border">150.00</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Totales -->
        <section class="mt-4">
            <div class="flex justify-end">
                <div class="w-1/3">
                    <div class="flex justify-between">
                        <span class="font-semibold">Subtotal:</span>
                        <span>S/. 250.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">IGV (18%):</span>
                        <span>S/. 45.00</span>
                    </div>
                    <div class="flex justify-between pt-2 mt-2 font-semibold border-t border-gray-400">
                        <span>Total:</span>
                        <span>S/. 295.00</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Código QR -->
        <section class="mt-6 text-center">
            <!-- Imagen de ejemplo para el código QR -->
            <img src="https://via.placeholder.com/150x150.png?text=QR+Code" alt="Código QR" class="mx-auto">
        </section>

        <!-- Pie de página -->
        <footer class="mt-6 text-xs text-center">
            <p>Gracias por su compra.</p>
            <p>Esta factura ha sido generada según las normas peruanas.</p>
        </footer>
    </div>
</body>

</html>