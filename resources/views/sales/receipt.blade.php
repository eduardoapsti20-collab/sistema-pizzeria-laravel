<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8.5pt;
            margin: 5mm;
            color: #1a1a1a;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        /* ===== HEADER ===== */
        .header { text-align: center; margin-bottom: 8px; }
        .brand {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
            letter-spacing: 0.5px;
        }
        .header-info {
            font-size: 7.5pt;
            color: #555;
            line-height: 1.5;
        }

        .divider {
            border-top: 1px dashed #999;
            margin: 8px 0;
        }
        .divider-solid {
            border-top: 1.5px solid #1a1a1a;
            margin: 6px 0;
        }

        /* ===== TIPO DE COMPROBANTE ===== */
        .comprobante-box {
            text-align: center;
            margin: 8px 0;
            padding: 5px 0;
            border: 1px solid #1a1a1a;
        }
        .comprobante-tipo {
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .comprobante-numero {
            font-size: 9pt;
            font-weight: bold;
            margin-top: 2px;
        }
        .comprobante-doc {
            font-size: 7.5pt;
            color: #555;
            margin-top: 2px;
        }

        /* ===== METADATOS (ticket, fecha, mesa, mesero, cliente) ===== */
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        .meta-table td {
            padding: 1.5px 0;
            font-size: 8pt;
            vertical-align: top;
        }
        .meta-label {
            width: 60px;
            color: #666;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 7pt;
        }
        .meta-value {
            font-weight: bold;
            color: #000;
        }

        .section-title {
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
            margin: 8px 0 4px 0;
        }

        /* ===== TABLA DE PRODUCTOS ===== */
        table.items-table { width: 100%; border-collapse: collapse; }
        .items-table thead th {
            border-bottom: 1.5px solid #1a1a1a;
            padding: 4px 0;
            text-align: left;
            font-size: 7.5pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #333;
        }
        .items-table tbody tr {
            border-bottom: 0.5pt dotted #ccc;
        }
        .items-table td {
            padding: 6px 0;
            vertical-align: top;
        }

        .item-name {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5pt;
        }
        .item-size {
            display: block;
            font-size: 7.5pt;
            font-weight: normal;
            color: #444;
            margin-top: 1px;
        }

        /* ===== TOTALES ===== */
        .totals-box {
            margin-top: 8px;
            width: 100%;
        }
        .totals-box table { width: 100%; border-collapse: collapse; }
        .totals-box td {
            padding: 3px 0;
        }
        .subtle-row td {
            color: #555;
            font-size: 8pt;
        }
        .total-row td {
            font-size: 12pt;
            font-weight: bold;
            border-top: 1.5px solid #1a1a1a;
            padding-top: 6px;
            padding-bottom: 6px;
        }
        .payment-row td {
            color: #444;
            font-size: 8pt;
            padding-top: 4px;
        }

        /* ===== QR / FOOTER ===== */
        .qr-section {
            text-align: center;
            margin-top: 18px;
        }
        .qr-section img {
            width: 95px;
            height: 95px;
        }
        .footer-msg {
            font-size: 7pt;
            margin-top: 8px;
            text-transform: uppercase;
            line-height: 1.6;
            color: #333;
            letter-spacing: 0.3px;
        }
    </style>
</head>
<body>

    <div class="header">
    @if ($logoBase64)
        <img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 90px; max-height: 90px; margin-bottom: 6px;">
    @endif
    <div class="brand">{{ $empresa->company_name }}</div>
    <div class="header-info">
            {{ $empresa->company_address }}<br>
            NIT: {{ $empresa->tax_id }} &nbsp;|&nbsp; Tel: {{ $empresa->company_phone }}<br>
            {{ $empresa->company_email }}
        </div>
    </div>

    <div class="divider-solid"></div>

    @php
        $etiquetasComprobante = [
            'boleta' => 'Boleta de Venta Electrónica',
            'factura' => 'Factura Electrónica',
            'nota_venta' => 'Nota de Venta',
        ];
        $etiquetaComprobante = $etiquetasComprobante[$sale->tipo_comprobante] ?? 'Nota de Venta';
        $etiquetaDocCliente = $sale->cliente_tipo_documento === 'RUC' ? 'RUC' : 'DNI';
    @endphp

    <div class="comprobante-box">
        <div class="comprobante-tipo">{{ $etiquetaComprobante }}</div>
        @if ($sale->requiereSunat())
            <div class="comprobante-numero">{{ $sale->numero_completo ?? 'Pendiente de asignar' }}</div>
        @endif
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Ticket</td>
            <td class="meta-value">{{ $sale->sale_code }}</td>
            <td class="meta-label text-right">Fecha</td>
            <td class="meta-value text-right">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Mesa</td>
            <td class="meta-value">{{ $sale->order->table->name ?? 'N/A' }}</td>
            <td class="meta-label text-right">Mesero</td>
            <td class="meta-value text-right">{{ $sale->order->user->name ?? 'Sistema' }}</td>
        </tr>
        @if ($sale->requiereSunat())
            <tr>
                <td class="meta-label">Cliente</td>
                <td class="meta-value" colspan="3">{{ strtoupper($sale->cliente_denominacion ?: 'Cliente Varios') }}</td>
            </tr>
            @if ($sale->cliente_numero_documento)
                <tr>
                    <td class="meta-label">{{ $etiquetaDocCliente }}</td>
                    <td class="meta-value" colspan="3">{{ $sale->cliente_numero_documento }}</td>
                </tr>
            @endif
            @if ($sale->cliente_direccion)
                <tr>
                    <td class="meta-label">Dirección</td>
                    <td class="meta-value" colspan="3">{{ $sale->cliente_direccion }}</td>
                </tr>
            @endif
        @else
            <tr>
                <td class="meta-label">Cliente</td>
                <td class="meta-value" colspan="3">{{ strtoupper($sale->customer_name ?? 'Consumidor Final') }}</td>
            </tr>
        @endif
    </table>

    <div class="section-title">Detalle del pedido</div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Desc.</th>
                <th class="text-right">Cant</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->details as $item)
                <tr>
                    <td>
                        <span class="item-name">
                            {{ $item->product->name ?? 'Producto eliminado' }}
                        </span>
                        @if ($item->productSize)
                            <span class="item-size">Tamaño: {{ $item->productSize->name }}</span>
                        @endif
                    </td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->price, 2) }}</td>
                    <td class="text-right bold">{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals-box">
        <table>
            <tr class="subtle-row">
                <td>Subtotal</td>
                <td class="text-right">{{ $empresa->currency_simbol }}{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            @if ($sale->tip > 0)
                <tr class="subtle-row">
                    <td>Propina</td>
                    <td class="text-right">{{ $empresa->currency_simbol }}{{ number_format($sale->tip, 2) }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL</td>
                <td class="text-right">{{ $empresa->currency_simbol }}{{ number_format($sale->total, 2) }}</td>
            </tr>
            <tr class="payment-row">
                <td>Pago con</td>
                <td class="text-right">{{ $empresa->currency_simbol }}{{ number_format($sale->paid_amount, 2) }}</td>
            </tr>
            <tr class="payment-row">
                <td>Devuelta</td>
                <td class="text-right">{{ $empresa->currency_simbol }}{{ number_format($sale->change, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="qr-section">
        <img src="{{ $qrCodeBase64 }}" alt="QR Code">
        <p class="footer-msg">
            ¡Gracias por su preferencia!
            @if ($sale->requiereSunat())
                @if ($sale->enlace_pdf)
                    <br>Escanea para ver tu {{ $sale->tipo_comprobante === 'factura' ? 'factura' : 'boleta' }} electrónica
                @elseif ($sale->estado_sunat === 'error')
                    <br><strong>Comprobante aún no enviado a SUNAT — reintentar desde el sistema</strong>
                @else
                    <br>Tu {{ $sale->tipo_comprobante === 'factura' ? 'factura' : 'boleta' }} electrónica se está procesando
                @endif
            @endif
        </p>
    </div>

</body>
</html>