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
        .header { text-align: center; margin-bottom: 6px; }
        .brand {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
            letter-spacing: 0.3px;
        }
        .header-info {
            font-size: 7.5pt;
            color: #333;
            line-height: 1.5;
        }
        .ruc-line {
            text-align: center;
            font-size: 8.5pt;
            font-weight: bold;
            margin-top: 4px;
        }

        .divider {
            border-top: 1px dashed #999;
            margin: 7px 0;
        }
        .divider-solid {
            border-top: 1.5px solid #1a1a1a;
            margin: 6px 0;
        }

        /* ===== TIPO DE COMPROBANTE ===== */
        .comprobante-box {
            text-align: center;
            margin: 6px 0;
        }
        .comprobante-tipo {
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .comprobante-numero {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 2px;
            letter-spacing: 0.5px;
        }

        /* ===== DATOS DE VENTA/CLIENTE ===== */
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 2px; }
        .meta-table td {
            padding: 1.5px 0;
            font-size: 7.8pt;
            vertical-align: top;
        }
        .meta-label {
            font-weight: bold;
            white-space: nowrap;
            padding-right: 4px;
        }
        .meta-value {
            color: #000;
        }

        .section-title {
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
            margin: 6px 0 3px 0;
        }

        /* ===== TABLA DE PRODUCTOS ===== */
        table.items-table { width: 100%; border-collapse: collapse; }
        .items-table thead th {
            border-bottom: 1.5px solid #1a1a1a;
            padding: 4px 0;
            text-align: left;
            font-size: 7.3pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #333;
        }
        .items-table tbody tr {
            border-bottom: 0.5pt dotted #ccc;
        }
        .items-table td {
            padding: 5px 0;
            vertical-align: top;
            font-size: 8pt;
        }

        .item-name {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8pt;
        }
        .item-size {
            display: block;
            font-size: 7pt;
            font-weight: normal;
            color: #444;
            margin-top: 1px;
        }

        /* ===== TOTALES ===== */
        .totals-box { margin-top: 6px; width: 100%; }
        .totals-box table { width: 100%; border-collapse: collapse; }
        .totals-box td {
            padding: 2px 0;
            font-size: 8pt;
        }
        .total-row td {
            font-size: 11pt;
            font-weight: bold;
            border-top: 1.5px solid #1a1a1a;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .son-line {
            font-size: 7.5pt;
            font-weight: bold;
            margin: 4px 0;
        }
        .payment-table { width: 100%; border-collapse: collapse; margin-top: 2px; }
        .payment-table td {
            padding: 1.5px 0;
            font-size: 7.8pt;
        }
        .payment-table .meta-label { width: 90px; }

        /* ===== QR / FOOTER ===== */
        .qr-section {
            text-align: center;
            margin-top: 14px;
        }
        .qr-section img {
            width: 90px;
            height: 90px;
        }
        .footer-msg {
            font-size: 7pt;
            margin-top: 6px;
            line-height: 1.6;
            color: #333;
            letter-spacing: 0.2px;
        }
        .footer-msg strong { text-transform: uppercase; }
    </style>
</head>
<body>

    @php
        $etiquetasComprobante = [
            'boleta' => 'Boleta de Venta Electrónica',
            'factura' => 'Factura Electrónica',
            'nota_venta' => 'Nota de Venta',
        ];
        $etiquetaComprobante = $etiquetasComprobante[$sale->tipo_comprobante] ?? 'Nota de Venta';
        $etiquetaDocCliente = $sale->cliente_tipo_documento === 'RUC' ? 'RUC' : 'DNI';

        $totalVenta = (float) $sale->total;
        $igvVenta = round($totalVenta - ($totalVenta / 1.18), 2);
        $gravadaVenta = round($totalVenta - $igvVenta, 2);

        if (!function_exists('convertirNumeroALetrasSoles')) {
            function convertirNumeroALetrasSoles($numero)
            {
                $entero = (int) floor($numero);
                $centavos = (int) round((round($numero, 2) - $entero) * 100);

                $unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
                $especiales = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
                $decenas = ['', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
                $centenas = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];

                $convertirGrupo = function ($n) use ($unidades, $especiales, $decenas, $centenas) {
                    if ($n == 0) return '';
                    if ($n == 100) return 'CIEN';
                    $texto = '';
                    $c = intdiv($n, 100);
                    $resto = $n % 100;
                    if ($c > 0) $texto .= $centenas[$c] . ' ';
                    if ($resto >= 10 && $resto < 20) {
                        $texto .= $especiales[$resto - 10];
                    } elseif ($resto >= 20) {
                        $d = intdiv($resto, 10);
                        $u = $resto % 10;
                        $texto .= $decenas[$d];
                        if ($u > 0) $texto .= ' Y ' . $unidades[$u];
                    } elseif ($resto > 0) {
                        $texto .= $unidades[$resto];
                    }
                    return trim($texto);
                };

                if ($entero == 0) {
                    $textoEntero = 'CERO';
                } else {
                    $miles = intdiv($entero, 1000);
                    $resto = $entero % 1000;
                    $textoEntero = '';
                    if ($miles > 0) {
                        $textoEntero .= ($miles == 1 ? 'MIL' : $convertirGrupo($miles) . ' MIL') . ' ';
                    }
                    if ($resto > 0) {
                        $textoEntero .= $convertirGrupo($resto);
                    }
                    $textoEntero = trim($textoEntero);
                }

                return $textoEntero . ' CON ' . str_pad((string) $centavos, 2, '0', STR_PAD_LEFT) . '/100 SOLES';
            }
        }
    @endphp

    <div class="header">
        @if ($logoBase64)
            <img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 80px; max-height: 80px; margin-bottom: 5px;">
        @endif
        <div class="brand">{{ $empresa->company_name }}</div>
        <div class="header-info">
            {{ $empresa->company_address }}<br>
            Tel: {{ $empresa->company_phone }}<br>
            {{ $empresa->company_email }}
        </div>
        @if ($sale->requiereSunat() && $empresa->tax_id)
            <div class="ruc-line">RUC: {{ $empresa->tax_id }}</div>
        @endif
    </div>

    <div class="divider-solid"></div>

    <div class="comprobante-box">
        <div class="comprobante-tipo">{{ strtoupper($etiquetaComprobante) }}</div>
        @if ($sale->requiereSunat())
            <div class="comprobante-numero">{{ $sale->numero_completo ?? 'Pendiente de asignar' }}</div>
        @else
            <div class="comprobante-numero">{{ $sale->sale_code }}</div>
        @endif
    </div>

    <div class="divider"></div>

    <table class="meta-table">
        <tr>
            <td class="meta-label" style="width:70px;">Cliente:</td>
            <td class="meta-value">
                {{ $sale->requiereSunat()
                    ? strtoupper($sale->cliente_denominacion ?: 'Clientes Varios')
                    : strtoupper($sale->customer_name ?? 'Consumidor Final') }}
            </td>
        </tr>
        @if ($sale->requiereSunat() && $sale->cliente_numero_documento)
            <tr>
                <td class="meta-label">{{ $etiquetaDocCliente }}:</td>
                <td class="meta-value">{{ $sale->cliente_numero_documento }}</td>
            </tr>
        @endif
        @if ($sale->requiereSunat() && $sale->cliente_direccion)
            <tr>
                <td class="meta-label">Dirección:</td>
                <td class="meta-value">{{ $sale->cliente_direccion }}</td>
            </tr>
        @endif
        <tr>
            <td class="meta-label">Fecha emisión:</td>
            <td class="meta-value">{{ $sale->created_at->format('d/m/Y') }} &nbsp;&nbsp; Hora: {{ $sale->created_at->format('h:i A') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Moneda:</td>
            <td class="meta-value">{{ $empresa->currency_simbol === '$' ? 'Dólares' : 'Soles' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Ticket:</td>
            <td class="meta-value">{{ $sale->sale_code }} &nbsp;|&nbsp; Mesa: {{ $sale->order->table->name ?? 'N/A' }} &nbsp;|&nbsp; Mesero: {{ $sale->order->user->name ?? 'Sistema' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Cant.</th>
                <th>Descripción</th>
                <th class="text-right">P.U.</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->details as $item)
                <tr>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        <span class="item-name">
                            {{ $item->product->name ?? 'Producto eliminado' }}
                        </span>
                        @if ($item->productSize)
                            <span class="item-size">Tamaño: {{ $item->productSize->name }}</span>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($item->price, 2) }}</td>
                    <td class="text-right bold">{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals-box">
        <table>
            @if ($sale->requiereSunat())
                <tr>
                    <td>Gravada</td>
                    <td class="text-right">{{ $empresa->currency_simbol }} {{ number_format($gravadaVenta, 2) }}</td>
                </tr>
                <tr>
                    <td>IGV 18%</td>
                    <td class="text-right">{{ $empresa->currency_simbol }} {{ number_format($igvVenta, 2) }}</td>
                </tr>
            @endif
            @if ($sale->tip > 0)
                <tr>
                    <td>Propina</td>
                    <td class="text-right">{{ $empresa->currency_simbol }} {{ number_format($sale->tip, 2) }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL</td>
                <td class="text-right">{{ $empresa->currency_simbol }} {{ number_format($totalVenta, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="son-line">SON: {{ convertirNumeroALetrasSoles($totalVenta) }}</div>

    <div class="divider"></div>

    <table class="payment-table">
        <tr>
            <td class="meta-label">Pago con:</td>
            <td>{{ $empresa->currency_simbol }} {{ number_format($sale->paid_amount, 2) }}</td>
        </tr>
        <tr>
            <td class="meta-label">Vuelto:</td>
            <td>{{ $empresa->currency_simbol }} {{ number_format($sale->change, 2) }}</td>
        </tr>
        <tr>
            <td class="meta-label">Atendido por:</td>
            <td>{{ $sale->order->user->name ?? 'Sistema' }}</td>
        </tr>
    </table>

    <div class="qr-section">
        <img src="{{ $qrCodeBase64 }}" alt="QR Code">
        <p class="footer-msg">
            <strong>¡Gracias por su preferencia!</strong>
            @if ($sale->requiereSunat())
                @if ($sale->enlace_pdf)
                    <br>Representación impresa de la {{ $etiquetaComprobante }}, escanea el código para verla.
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
