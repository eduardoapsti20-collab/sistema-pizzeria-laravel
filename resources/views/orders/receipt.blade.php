<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
            padding: 3px;
            color: #000;
        }

        .ticket {
            width: 95%;
            max-width: 300px;
            margin: 0 auto;
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            max-width: 55px;
            max-height: 55px;
            margin-bottom: 5px;
        }

        .brand {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
            word-break: break-word;
        }

        .header div {
            font-size: 10px;
            margin: 1px 0;
            word-break: break-word;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
            width: 100%;
        }

        .sale-details p {
            font-size: 11px;
            margin: 2px 0;
            line-height: 1.4;
            word-break: break-word;
        }

        .sale-details strong {
            display: inline-block;
            min-width: 45px;
        }

        table.items-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 5px;
        }

        .items-table th,
        .items-table td {
            padding: 3px 2px;
            text-align: left;
            font-size: 10px;
            word-break: break-word;
        }

        .items-table th {
            border-bottom: 1px solid #000;
            font-size: 9px;
        }

        .item-name {
            font-weight: bold;
        }

        .item-size,
        .item-note {
            display: block;
            font-size: 9px;
            font-weight: normal;
            color: #333;
        }

        .item-note {
            font-style: italic;
        }

       table.totals-table {
    width: 70%;
    margin-left: auto;
    margin-right: 4px;
    border-collapse: collapse;
    margin-top: 8px;
}

        .totals-table td {
    padding-top: 6px;
    font-size: 13px;
    font-weight: bold;
}

        .footer-msg {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="ticket">

        <div class="header">
            @if (!empty($logoBase64))
                <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
            @endif
            <div class="brand">{{ $empresa->company_name }}</div>
            <div>{{ $empresa->company_address }}</div>
            <div>NIT: {{ $empresa->tax_id }}</div>
            <div>TEL: {{ $empresa->company_phone }}</div>
            <div>{{ $empresa->company_email }}</div>
        </div>

        <div class="divider"></div>

        <div class="sale-details">
            <p><strong>Ticket:</strong> {{ $order->order_code }}</p>
            <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Mesa:</strong> {{ $order->table->name ?? 'N/A' }}</p>
            <p><strong>Mesero:</strong> {{ $order->user->name ?? 'Sistema' }}</p>
            <p><strong>Cliente:</strong> {{ strtoupper($order->customer_name ?? 'Consumidor Final') }}</p>
        </div>

        <div class="divider"></div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 46%;">DESC.</th>
                    <th style="width: 12%;" class="text-right">CANT</th>
                    <th style="width: 20%;" class="text-right">P/U</th>
                    <th style="width: 22%;" class="text-right">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->details->where('cooking_status', '!=', 'cancelled') as $item)
                    <tr>
                        <td style="width: 46%;">
                            <span class="item-name">{{ $item->product->name ?? 'Producto eliminado' }}</span>
                            @if ($item->productSize)
                                <span class="item-size">{{ $item->productSize->name }}</span>
                            @endif
                            @if ($item->notes)
                                <span class="item-note">{{ $item->notes }}</span>
                            @endif
                        </td>
                        <td style="width: 12%;" class="text-right">{{ $item->quantity }}</td>
                        <td style="width: 20%;" class="text-right">{{ number_format($item->price, 2) }}</td>
                        <td style="width: 22%;" class="text-right bold">
                            {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- SECCIÓN DEL TOTAL — solo suma ítems activos, excluye cancelados --}}
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="border-top: 1px dashed #000; padding: 0;"></td>
    </tr>
</table>
<table class="totals-table">
            <tr>
                <td class="text-left">TOTAL:</td>
                <td class="text-right">
                    {{ $empresa->currency_simbol }}
                    {{ number_format($order->details->where('cooking_status', '!=', 'cancelled')->sum('subtotal'), 2) }}
                </td>
            </tr>
        </table>

        <div class="footer-msg">
            <p>¡Gracias por su visita!</p>
        </div>

    </div>

</body>

</html>