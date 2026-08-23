<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Caja - {{ $caja->name }}</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            color: #334155;
            font-size: 12px;
            line-height: 1.5;
        }

        /* Encabezado Estilo Pro */
        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
        }

        .report-title {
            font-size: 14px;
            color: #64748b;
            font-weight: bold;
            margin-top: 5px;
        }

        /* Columnas de Información */
        .info-section {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-box {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }

        .label {
            font-size: 10px;
            color: #94a3b8;
            font-weight: bold;
            text-transform: uppercase;
        }

        .value {
            font-size: 12px;
            color: #1e293b;
            font-weight: bold;
        }

        /* RESUMEN GENERAL (NUEVO): Apertura / Ventas / Gastos / Saldo en una fila */
        .resumen-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .resumen-table th {
            background: #f8fafc;
            color: #94a3b8;
            font-size: 9px;
            text-transform: uppercase;
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        .resumen-table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            font-weight: bold;
        }

        .resumen-apertura {
            color: #1e293b;
        }

        .resumen-ventas {
            color: #059669;
        }

        .resumen-gastos {
            color: #dc2626;
        }

        .resumen-saldo {
            background: #eef2ff;
            color: #4f46e5;
        }

        /* Tabla de Métodos de Pago */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .summary-table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 10px;
            padding: 10px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        .summary-table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            font-weight: bold;
        }

        /* Tablas de Ventas / Gastos (NUEVO: separadas en vez de una sola cronología) */
        .section-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 0;
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 2px solid;
        }

        .section-title-ventas {
            color: #059669;
            border-color: #059669;
        }

        .section-title-gastos {
            color: #dc2626;
            border-color: #dc2626;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.main-table th {
            background: #1e293b;
            color: white;
            padding: 8px;
            font-size: 10px;
            text-transform: uppercase;
        }

        table.main-table td {
            padding: 8px;
            border-bottom: 1px solid #f1f5f9;
        }

        table.main-table.tabla-ventas th {
            background: #065f46;
        }

        table.main-table.tabla-gastos th {
            background: #991b1b;
        }

        .no-data {
            text-align: center;
            color: #94a3b8;
            font-style: italic;
            padding: 15px;
        }

        /* Clases de Utilidad */
        .text-right {
            text-align: right;
        }

        .ingreso {
            color: #059669;
            font-weight: bold;
        }

        .egreso {
            color: #dc2626;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="company-name">{{ $empresa->company_name ?? 'MI EMPRESA' }}</div>
        <div class="report-title">ARQUEO DETALLADO DE CAJA</div>
    </div>

    <div class="info-section">
        <div class="info-box">
            <div class="label">Caja Identificador:</div>
            <div class="value">{{ $caja->name }}</div>
            <div class="label" style="margin-top:10px">Responsable:</div>
            <div class="value">{{ $caja->opener->name }}</div>
        </div>
        <div class="info-box text-right">
            <div class="label">Fecha de Apertura:</div>
            <div class="value">{{ ($caja->opened_at ?? $caja->created_at)->format('d/m/Y H:i') }}</div>
            <div class="label" style="margin-top:10px">Estado Actual:</div>
            <div class="value" style="color: {{ $caja->status == 'open' ? '#059669' : '#64748b' }}">
                {{ $caja->status == 'open' ? 'SESIÓN ABIERTA' : 'SESIÓN CERRADA' }}
                @if ($caja->closed_at)
                    ({{ $caja->closed_at->format('d/m/Y H:i') }})
                @endif
            </div>
        </div>
    </div>

    {{-- RESUMEN GENERAL (NUEVO): Apertura / Ventas / Gastos / Saldo separados de un vistazo --}}
    <h3 class="label">Resumen General</h3>
    <table class="resumen-table">
        <thead>
            <tr>
                <th>Apertura</th>
                <th>Ventas</th>
                <th>Gastos</th>
                <th>Saldo Actual</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="resumen-apertura">
                    {{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($caja->opening_amount, 2) }}
                </td>
                <td class="resumen-ventas">
                    +{{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($caja->sales->sum('total'), 2) }}
                    <span style="font-size: 9px; font-weight: normal; color: #64748b;">({{ $caja->sales->count() }})</span>
                </td>
                <td class="resumen-gastos">
                    -{{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($gastos->sum('amount'), 2) }}
                    <span style="font-size: 9px; font-weight: normal; color: #64748b;">({{ $gastos->count() }})</span>
                </td>
                <td class="resumen-saldo">
                    {{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($caja->current_amount, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <h3 class="label">Resumen por Métodos de Pago</h3>
    <table class="summary-table">
        <thead>
            <tr>
                @foreach ($pagosPorMetodo as $metodo => $total)
                    <th>{{ $metodo }}</th>
                @endforeach
                <th style="background: #eef2ff; color: #4f46e5;">SALDO TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($pagosPorMetodo as $metodo => $total)
                    <td>{{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($total, 2) }}</td>
                @endforeach
                <td style="background: #eef2ff; color: #4f46e5;">
                    {{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($caja->current_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- TABLA DE VENTAS (NUEVO: separada de gastos) --}}
    <div class="section-title section-title-ventas">Ventas ({{ $caja->sales->count() }})</div>
    <table class="main-table tabla-ventas">
        <thead>
            <tr>
                <th align="left" width="15%">Hora</th>
                <th align="left" width="15%">Venta #</th>
                <th align="left" width="30%">Método(s) de Pago</th>
                <th align="right" width="20%">Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($caja->sales->sortByDesc('created_at') as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('H:i') }}</td>
                    <td>#{{ $sale->id }}</td>
                    <td>{{ $sale->payments->map(fn($p) => $p->method->name)->implode(', ') }}</td>
                    <td class="text-right ingreso">
                        +{{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($sale->total, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="no-data">No hay ventas registradas en esta caja.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TABLA DE GASTOS (NUEVO: separada de ventas) --}}
    <div class="section-title section-title-gastos">Gastos ({{ $gastos->count() }})</div>
    <table class="main-table tabla-gastos">
        <thead>
            <tr>
                <th align="left" width="15%">Hora</th>
                <th align="left" width="45%">Concepto</th>
                <th align="left" width="20%">Método</th>
                <th align="right" width="20%">Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($gastos->sortByDesc('expense_date') as $g)
                <tr>
                    <td>{{ $g->expense_date->format('H:i') }}</td>
                    <td>{{ $g->concept }}{{ $g->description ? ' (' . $g->description . ')' : '' }}</td>
                    <td>{{ $g->paymentMethod->name ?? 'N/A' }}</td>
                    <td class="text-right egreso">
                        -{{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($g->amount, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="no-data">No hay gastos registrados en esta caja.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Este documento es un comprobante interno de movimientos de tesorería.
        Generado el {{ now()->format('d/m/Y H:i:s') }}
    </div>

</body>

</html>