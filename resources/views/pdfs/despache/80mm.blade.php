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

        .despache-number {
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
        <img src="{{ $despache->company->logo_path ? 'storage/' . $despache->company->logo_path : './img/logo.png' }}"
            alt="Logo" class="logo">
        <div class="company-info">
            <strong>BRAYAN BRUSH CORPORACION LOGISTICO</strong><br>
            R.U.C.: {{ $despache->company->ruc }}<br>
            {{ $despache->encomienda->sucursal_remitente->address }}<br>
            Telf: {{ $despache->encomienda->sucursal_remitente->phone }}<br>
            Email: {{ $despache->encomienda->sucursal_remitente->email }}
        </div>
    </div>

    <div class="despache-number">
        GUIA DE REMISION ELECTRONICA TRANSPORTISTA<br>
        {{ $despache->serie }} - {{ $despache->correlativo }}<br>
    </div>
    <div class="despache-number">
        @if ($despache->isHome)
            DOMICILIO
        @else
            AGENCIA
        @endif
    </div>

    <div class="customer-info">
        Fecha Emisión: {{ $despache->created_at->format('Y-m-d') }}<br>
        Fecha Traslado: {{ $despache->updated_at->format('Y-m-d') }}<br>
    </div>
    <div class="customer-info">
        <strong>DATOS REMITENTE</strong><br>
        Razón Social: {{ $despache->remitente->name }}<br>
        {{ strtoupper($despache->remitente->type_code == 1 ? 'DNI' : 'RUC') }}: {{ $despache->remitente->code }}<br>
        @if ($despache->remitente->address)
            Dirección: {{ $despache->remitente->address }}
        @endif
    </div>
    <div class="customer-info">
        <strong>DATOS DESTINATARIO</strong><br>
        Razón Social: {{ $despache->destinatario->name }}<br>
        {{ strtoupper($despache->destinatario->type_code == 1 ? 'DNI' : 'RUC') }}:
        {{ $despache->destinatario->code }}<br>
        @if ($despache->destinatario->address)
            Dirección: {{ $despache->destinatario->address }}
        @endif
    </div>
    <div class="customer-info">
        <strong>DATOS ENVIO</strong><br>
        <strong>ORIGEN :<br></strong>{{ $despache->encomienda->sucursal_remitente->address }}<br>
        <strong>DESTINO:<br></strong>{{ $despache->encomienda->sucursal_destinatario->address }}
    </div>
    <div class="customer-info">
        <strong>TRANSPORTE y CONDUCTOR</strong><br>
        <strong>PLACA N°: :</strong>{{ $despache->encomienda->vehiculo->name }}<br>
        <strong>DNI:</strong>{{ $despache->encomienda->transportista->dni }}<br>
        <strong>NOMBRE:</strong>{{ $despache->encomienda->transportista->name }}<br>
        <strong>LICENCIA:</strong>{{ $despache->encomienda->transportista->licencia }}
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
            @forelse ($despache->details as $detail)
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
                <td style="text-align: right">S/ {{ number_format($despache->valorVenta, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left">IGV (18%):</td>
                <td style="text-align: right">S/ {{ number_format($despache->mtoIGV, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><strong>Total:</strong></td>
                <td style="text-align: right"><strong>S/
                        {{ number_format($despache->mtoImpVenta, 2) }}</strong></td>
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
        Usuario: {{ $despache->encomienda->user->name }}
    </div>
</body>

</html>
