<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Factura - Perú</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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

        .bordered-box {
            border: 2px solid #000;
            padding: 1rem;
            /* Doble tamaño */
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <!-- Logo y datos de la empresa centrados -->
        <div class="mb-4 text-center">

            <div class="text-sm">
                <img src="https://via.placeholder.com/100x60.png?text=Logo" alt="Logo de la Empresa"
                    class="w-auto h-16 mx-auto mb-2">
                <p class="text-lg font-bold">Compañía XYZ S.A.C.</p>
                <p>RUC: 98765432109</p>
                <p>Dirección: Av. Principal 456, Lima, Perú</p>
                <p>Teléfono: (01) 123-4567</p>
                <p>Email: contacto@xyz.com</p>
            </div>
        </div>

        <!-- Título de la Factura y Número de Serie en un recuadro -->
        <div class="mb-4 bordered-box">
            <h1 class="text-xl font-bold">FACTURA</h1>
            <p class="text-sm">Serie: F001</p>
            <p class="text-sm">Correlativo: 123456</p>
        </div>

        <!-- Información del Cliente -->
        <section class="mb-4 text-sm">
            <p class="font-semibold">Para:</p>
            <p>Cliente Ejemplo</p>
            <p>DNI/RUC: 12345678</p>
            <p>Dirección: Calle Secundaria 789, Lima, Perú</p>
            <p>Teléfono: (01) 765-4321</p>
            <p>Email: cliente@ejemplo.com</p>
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
                    <tr>
                        <td class="px-2 py-1 border">Producto A</td>
                        <td class="px-2 py-1 text-right border">2</td>
                        <td class="px-2 py-1 text-right border">50.00</td>
                        <td class="px-2 py-1 text-right border">100.00</td>
                    </tr>
                    <tr>
                        <td class="px-2 py-1 border">Servicio B</td>
                        <td class="px-2 py-1 text-right border">1</td>
                        <td class="px-2 py-1 text-right border">150.00</td>
                        <td class="px-2 py-1 text-right border">150.00</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Totales -->
        <section class="mb-4 text-sm">
            <div class="flex justify-between">
                <span class="font-semibold">Subtotal:</span>
                <span>S/. 250.00</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">IGV (18%):</span>
                <span>S/. 45.00</span>
            </div>
            <div class="flex justify-between pt-1 mt-1 font-semibold border-t border-gray-400">
                <span>Total:</span>
                <span>S/. 295.00</span>
            </div>
        </section>

        <!-- Código QR -->
        <section class="mt-4 text-center">
            <!-- Imagen de ejemplo para el código QR -->
            <img src="https://via.placeholder.com/100x100.png?text=QR+Code" alt="Código QR" class="mx-auto">
        </section>

        <!-- Pie de página -->
        <footer class="mt-4 text-xs text-center">
            <p>Gracias por su compra.</p>
            <p>Esta factura ha sido generada según las normas peruanas.</p>
        </footer>
    </div>
</body>

</html>