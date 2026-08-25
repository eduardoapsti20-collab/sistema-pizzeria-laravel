<?php

namespace App\Mail;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComprobanteMail extends Mailable
{
    use Queueable, SerializesModels;

    public Sale $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function build()
    {
        $tipoLegible = match ($this->sale->tipo_comprobante) {
            'factura' => 'Factura',
            'boleta' => 'Boleta de Venta',
            'nota_credito' => 'Nota de Crédito',
            default => 'Comprobante',
        };

        return $this->subject("{$tipoLegible} {$this->sale->numero_completo}")
            ->view('emails.comprobante')
            ->with([
                'sale' => $this->sale,
                'tipoLegible' => $tipoLegible,
            ]);
    }
}
