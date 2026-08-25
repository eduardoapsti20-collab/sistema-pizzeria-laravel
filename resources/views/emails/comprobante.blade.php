<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:24px; margin:0;">
    <div style="max-width:480px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.06);">
        <div style="background:#0f172a; padding:24px; text-align:center;">
            <h1 style="color:#ffffff; font-size:18px; margin:0;">{{ $sale->cliente_denominacion ? '¡Gracias por tu compra!' : 'Tu comprobante' }}</h1>
        </div>
        <div style="padding:28px;">
            <p style="color:#334155; font-size:14px; line-height:1.6;">Hola{{ $sale->cliente_denominacion ? ' ' . $sale->cliente_denominacion : '' }},</p>
            <p style="color:#334155; font-size:14px; line-height:1.6;">
                Adjuntamos el enlace de tu <strong>{{ $tipoLegible }}</strong>
                @if($sale->numero_completo)
                    <strong>{{ $sale->numero_completo }}</strong>
                @endif
                por un total de <strong>S/ {{ number_format($sale->total, 2) }}</strong>.
            </p>

            @if($sale->enlace_pdf)
                <div style="text-align:center; margin:28px 0;">
                    <a href="{{ $sale->enlace_pdf }}" style="background:#ea580c; color:#fff; text-decoration:none; padding:12px 28px; border-radius:9999px; font-size:13px; font-weight:bold; letter-spacing:0.05em; text-transform:uppercase;">
                        Descargar PDF
                    </a>
                </div>
            @endif

            <p style="color:#94a3b8; font-size:12px; line-height:1.6;">Este correo fue generado automáticamente, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</body>
</html>
