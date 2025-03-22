<html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
        }
        .container {
            width: 100%;
        }
        .header-section {
            border: 1px solid #333;
            padding: 5mm;
            margin-bottom: 5mm;
        }
        .logo-section {
            display: inline-block;
            width: 35%;
            vertical-align: top;
        }
        .company-section {
            display: inline-block;
            width: 60%;
            text-align: right;
            vertical-align: top;
        }
        .invoice-title {
            border: 2px solid #333;
            text-align: center;
            padding: 2mm;
            margin: 5mm 0;
            font-weight: bold;
            font-size: 12pt;
        }
        .client-info {
            width: 100%;
            margin-bottom: 5mm;
            border-collapse: collapse;
        }
        .client-info td {
            padding: 2mm;
            border-bottom: 0.1mm solid #ccc;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }
        .items-table th, 
        .items-table td {
            border: 0.1mm solid #333;
            padding: 2mm;
        }
        .items-table th {
            background-color: #f0f0f0;
        }
        .totals {
            width: 35%;
            float: right;
            margin-top: 5mm;
            border-collapse: collapse;
        }
        .totals td {
            border: 0.1mm solid #333;
            padding: 2mm;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            border-top: 0.1mm solid #333;
            padding-top: 2mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="logo-section">
                <img src="{{ public_path('images/logo.png') }}" style="width: 150px;">
            </div>
            <div class="company-section">
                <h2 style="margin: 0;">EMPRESA S.A.C</h2>
                <p style="margin: 2mm 0;">RUC: 20123456789</p>
                <p style="margin: 2mm 0;">Av. Principal 123, Lima</p>
                <p style="margin: 2mm 0;">Teléfono: (01) 123-4567</p>
            </div>
        </div>

        <div class="invoice-title">
            FACTURA ELECTRÓNICA<br>
            F001-000001
        </div>

        <table class="client-info">
            <tr>
                <td width="15%"><strong>Cliente:</strong></td>
                <td width="35%">Juan Pérez</td>
                <td width="15%"><strong>Fecha:</strong></td>
                <td width="35%">01/01/2024</td>
            </tr>
            <tr>
            <tr>
                <td><strong>Dirección:</strong></td>
                <td>Av. Central 123, Lima</td>
                <td><strong>Condición:</strong></td>
                <td>Contado</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong></td>
                <td>(01) 987-6543</td>
                <td><strong>Placa:</strong></td>
                <td>ABC-123</td>
            </tr>
        </table>
        <table class="items-table">
            <thead>
                <tr></tr>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Producto 1</td>
                    <td>2</td>
                    <td>S/ 10.00</td>
                    <td>S/ 20.00</td>
                </tr>
                <tr></tr>
                    <td>Producto 2</td>
                    <td>1</td>
                    <td>S/ 15.00</td>
                    <td>S/ 15.00</td>
                </tr>
            </tbody>
        </table>
        <div class="totals">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">Gravada:</td>
                    <td style="text-align: right">S/ {{ number_format($ticket->valorVenta, 2) }}</td>
                </tr>
                <tr></tr>
                    <td style="text-align: left">Igv:</td>
                    <td style="text-align: right">S/ {{ number_format($ticket->valorIgv, 2) }}</td>
                </tr>
                <tr></tr>
                    <td style="text-align: left">Total:</td>
                    <td style="text-align: right">S/ 1222.00</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            Gracias por su compra<br>
            Políticas de Envío<br>
            Corporación Logística Brayan Brush EIRL<br>
            Usuario: Abel Arana
        </div>
    </div>
</body>
</html>