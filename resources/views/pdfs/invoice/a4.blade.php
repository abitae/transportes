<html>

<head>
    <title>Factura {{ $invoice->serie }} - {{ $invoice->correlativo }}</title>
    <style>
        body {
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 0;
            font-weight: bold;
            color: #222;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }

        /* Header Section */
        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .company-info {
            width: 60%;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            vertical-align: top;
        }

        .company-logo {
            max-width: 180px;
            margin-bottom: 5px;
        }

        .invoice-box {
            width: 40%;
            border: 1px solid #000;
            text-align: center;
            padding: 10px;
            vertical-align: top;
        }

        .invoice-title {
            font-size: 18px;
            margin: 5px 0;
        }

        /* Client Section */
        .client-info {
            margin: 20px 0;
            width: 100%;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .client-heading {
            font-size: 14px;
            margin-bottom: 5px;
            color: #e74c3c;
        }

        .client-detail {
            margin-bottom: 3px;
        }

        .client-label {
            font-weight: bold;
            margin-right: 5px;
            min-width: 100px;
            display: inline-block;
        }

        /* Products Table */
        .products-table {
            width: 100%;
            margin: 20px 0;
            border: 1px solid #ddd;
        }

        .products-header {
            background-color: #f1f5f9;
            font-size: 14px;
            font-weight: bold;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .products-header th {
            padding: 8px;
        }

        .product-item td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        /* Totals Section */
        .totals-table {
            width: 100%;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .total-amount {
            font-weight: bold;
        }

        .total-final {
            font-weight: bold;
            font-size: 16px;
        }

        .amount-in-words {
            font-style: italic;
            color: #555;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding: 15px;
            background-color: #f1f5f9;
            border-top: 1px solid #ddd;
            font-size: 12px;
            text-align: center;
            width: 100%;
        }

        .footer-table {
            width: 100%;
        }

        .qr-code {
            width: 100px;
            height: 100px;
        }

        .footer-content {
            vertical-align: top;
            padding-left: 15px;
            text-align: left;
        }
    </style>
</head>

<body>
    <!-- Header with Company and Invoice Information -->
    <table class="header">
        <tr>
            <td class="company-info">
                <img class="company-logo" src="./img/logo_format_ticket.jpg"
                    alt="BRAYAN BRUSH CORPORACION LOGISTICO" /><br>
                <strong>BRAYAN BRUSH CORPORACION LOGISTICO</strong><br>
                R.U.C.: {{ $invoice->company->ruc }}<br>
                {{ $invoice->sucursal->address }}<br>
                Telf: {{ $invoice->sucursal->phone }}<br>
                Email: {{ $invoice->sucursal->email }}
            </td>
            <td class="invoice-box">
                <h4>R.U.C.: {{ $invoice->company->ruc }}</h4>
                <h3 class="invoice-title">{{ $invoice->tipoDoc == '01' ? 'FACTURA ELECTRONICA' : 'BOLETA ELECTRONICA' }}
                </h3>
                <h4>{{ $invoice->serie }} - {{ $invoice->correlativo }}</h4>
            </td>
        </tr>
    </table>

    <!-- Client Information Section -->
    <div class="client-info">
        <h4 class="client-heading">DATOS CLIENTE:</h4>
        <div class="client-detail"><span class="client-label">RUC:</span>{{ $invoice->client->code }}</div>
        <div class="client-detail"><span class="client-label">RAZON SOCIAL:</span>{{ $invoice->client->name }}</div>
        <div class="client-detail"><span class="client-label">DIRECCION:</span>{{ $invoice->client->address }}</div>
    </div>

    <!-- Products Table Section -->
    <table class="products-table">
        <thead>
            <tr class="products-header">
                <th width="60%">Descripción</th>
                <th width="10%" class="text-right">Cant</th>
                <th width="15%" class="text-right">Precio</th>
                <th width="15%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoice->details as $detail)
                <tr class="product-item">
                    <td>{{ $detail->descripcion }}</td>
                    <td class="text-right">{{ $detail->cantidad }}</td>
                    <td class="text-right">{{ number_format($detail->mtoPrecioUnitario, 2) }}</td>
                    <td class="text-right">{{ number_format($detail->mtoPrecioUnitario * $detail->cantidad, 2) }}</td>
                </tr>
            @empty
                <tr class="product-item">
                    <td colspan="4" style="text-align: center;">No hay detalles disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Totals Section -->
    <table class="totals-table">
        <tr>
            <td width="60%" class="amount-in-words">SON: {{ $invoice->monto_letras }}</td>
            <td width="25%" class="text-right">Gravada:</td>
            <td width="15%" class="text-right">S/ {{ number_format($invoice->valorVenta, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-right">IGV (18%):</td>
            <td class="text-right">S/ {{ number_format($invoice->mtoIGV, 2) }}</td>
        </tr>
        <tr class="total-final">
            <td></td>
            <td class="text-right">Total:</td>
            <td class="text-right">S/ {{ number_format($invoice->valorVenta + $invoice->mtoIGV, 2) }}</td>
        </tr>
    </table>

    <!-- Footer Section -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td width="20%">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/100px-Codigo_QR.svg.png?20080824194905"
            alt="Código QR">
                </td>
                <td class="footer-content">
                    Gracias por su compra<br>
                    Políticas de Envío<br>
                    Corporación Logística Brayan Brush EIRL<br>
                    Usuario: {{ $invoice->encomienda->user->name ?? Auth::user()->name }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
