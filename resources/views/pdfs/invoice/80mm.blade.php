<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 10px;
            margin-bottom: 10px;
        }

        .invoice-number {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            text-align: center;
            font-weight: bold;
        }

        .customer-info {
            font-size: 10px;
            margin: 4px 0;
            border-bottom: 1px solid #000;
            padding-top: 5px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin: 10px 0;
        }

        .items-table th,
        .items-table td {
            padding: 3px;
            text-align: left;
        }

        .items-table th {
            background-color: #f0f0f0;
        }

        .totals {
            font-size: 10px;
            text-align: right;
            margin: 10px 0;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .qr-code {
            text-align: center;
            margin: 10px 0;
        }

        .qr-code img {
            width: 100px;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ $invoice->company->logo_path ? 'storage/' . $invoice->company->logo_path : './img/logo.png' }}"
            alt="Logo" class="logo">
        <div class="company-info">
            <strong>{{ $invoice->company->razonSocial }}</strong><br>
            R.U.C.: {{ $invoice->company->ruc }}<br>
            {{ $invoice->sucursal->address }}<br>
            Telf: {{ $invoice->sucursal->phone }}<br>
            Email: {{ $invoice->sucursal->email }}
        </div>
    </div>

    <div class="invoice-number">
        {{ $invoice->tipoDoc == '01' ? 'FACTURA ELECTRONICA' : 'BOLETA ELECTRONICA' }}<br>
        {{ $invoice->serie }} - {{ $invoice->correlativo }}
    </div>
    <div class="customer-info">
        Fecha Emisión: {{ $invoice->created_at->format('Y-m-d') }}<br>
        Metodo de Pago: {{ $invoice->encomienda->metodo_pago }}<br>
    </div>
    <div class="customer-info">
        <strong>DATOS CLIENTE</strong><br>
        Razón Social: {{ $invoice->client->name }}<br>
        {{ strtoupper($invoice->client->type_code == 1 ? 'DNI' : 'RUC') }}: {{ $invoice->client->code }}<br>
        @if ($invoice->client->address)
            Dirección: {{ $invoice->client->address }}
        @endif
    </div>
    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th style="text-align: right">Cant</th>
                <th style="text-align: right">Precio</th>
                <th style="text-align: right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoice->details as $detail)
                <tr>
                    <td>{{ $detail->descripcion }}</td>
                    <td style="text-align: right">{{ $detail->cantidad }}</td>
                    <td style="text-align: right">{{ $detail->mtoPrecioUnitario }}</td>
                    <td style="text-align: right">
                        {{ number_format($detail->mtoPrecioUnitario * $detail->cantidad, 2) }}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>

    <div class="totals">
        <table style="width: 100%">
            <tr>
                <td style="text-align: left">Gravada:</td>
                <td style="text-align: right">S/ {{ number_format($invoice->valorVenta, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left">IGV (18%):</td>
                <td style="text-align: right">S/ {{ number_format($invoice->mtoIGV, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><strong>Total:</strong></td>
                <td style="text-align: right"><strong>S/
                        {{ number_format($invoice->mtoImpVenta, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="qr-code">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/100px-Codigo_QR.svg.png?20080824194905"
            alt="Código QR">
    </div>

    <div class="footer">
        Gracias por su compra<br>
        Políticas de Envío<br>
        Corporación Logística Brayan Brush EIRL<br>
        Usuario: {{ $invoice->encomienda->user->name ?? Auth::user()->name }}
    </div>
</body>

</html>
