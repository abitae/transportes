<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Cierre de Caja</title>
    <style>
        html {
            margin: 5pt 10pt;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0px;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Reporte Caja</h1>
    <p>Fecha Apertu: <span>{{ $caja->created_at->format('d/m/Y H:i:s') }}</span></p>
    <p>Fecha Cierre: <span>{{ $caja->updated_at->format('d/m/Y H:i:s') }}</span></p>
    <p>Cajero/a : <span>{{ $caja->user->name }}</span></p>

    <!-- Tabla de Ingresos -->
    <h2>Ingresos</h2>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($caja->entries as $entrie)
            <tr>
                <td>
                    {{ $entrie->description }}
                </td>
                <td>
                    {{ $entrie->monto_entry }}
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    No existe registros
                </td>
            </tr>
            @endforelse

        </tbody>
        <tfoot>
            <tr>
                <th>Total Ingresos</th>
                <th>{{ $caja->entries->sum('monto_entry') }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- Tabla de Egresos -->
    <h2>Egresos</h2>
    <table id="egresos">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($caja->exits as $exit)
            <tr>
                <td>
                    {{ $exit->description }}
                </td>
                <td>
                    {{ $exit->monto_exit }}
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    No existe registros
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total Egresos</th>
                <th>{{ $caja->exits->sum('monto_exit') }}</th>
            </tr>
        </tfoot>
    </table>
    <p>Saldo Inicial: <span>{{ $caja->monto_apertura }}</span></p>
    <p>Saldo final: <span>{{ $caja->monto_cierre }}</span></p>
</body>

</html>