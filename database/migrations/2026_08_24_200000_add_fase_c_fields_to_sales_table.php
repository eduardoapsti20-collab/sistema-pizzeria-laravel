<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Se usa SQL directo para modificar los ENUM porque el proyecto no tiene
        // doctrine/dbal instalado (requerido por Schema::table(...)->change()).
        DB::statement("ALTER TABLE sales MODIFY tipo_comprobante ENUM('nota_venta', 'boleta', 'factura', 'nota_credito') DEFAULT 'nota_venta'");
        DB::statement("ALTER TABLE sales MODIFY estado_sunat ENUM('no_aplica', 'pendiente', 'aceptado', 'error', 'anulacion_solicitada', 'anulado') DEFAULT 'no_aplica'");

        Schema::table('sales', function (Blueprint $table) {
            // Motivo escrito por el cajero/administrador al anular o generar nota de credito
            $table->text('motivo_anulacion')->nullable()->after('comprobante_referencia_id');

            // Numero de ticket que devuelve Nubefact al pedir una anulacion (comunicacion de baja),
            // se usa despues para consultar si SUNAT ya la proceso.
            $table->string('ticket_anulacion')->nullable()->after('motivo_anulacion');

            // Email del cliente, opcional, para poder enviarle el PDF del comprobante
            $table->string('cliente_email')->nullable()->after('cliente_direccion');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['motivo_anulacion', 'ticket_anulacion', 'cliente_email']);
        });

        DB::statement("ALTER TABLE sales MODIFY tipo_comprobante ENUM('nota_venta', 'boleta', 'factura') DEFAULT 'nota_venta'");
        DB::statement("ALTER TABLE sales MODIFY estado_sunat ENUM('no_aplica', 'pendiente', 'aceptado', 'error') DEFAULT 'no_aplica'");
    }
};
