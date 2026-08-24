<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Tipo de comprobante elegido en caja
            $table->enum('tipo_comprobante', ['nota_venta', 'boleta', 'factura'])
                ->default('nota_venta')
                ->after('sale_code');

            // Datos del cliente (solo obligatorios para boleta/factura)
            $table->string('cliente_tipo_documento', 20)->nullable()->after('tipo_comprobante'); // DNI, RUC, SIN_DOCUMENTO
            $table->string('cliente_numero_documento', 20)->nullable()->after('cliente_tipo_documento');
            $table->string('cliente_denominacion')->nullable()->after('cliente_numero_documento'); // nombre o razon social
            $table->string('cliente_direccion')->nullable()->after('cliente_denominacion');

            // Serie y correlativo asignados por Nubefact (independiente del sale_code interno)
            $table->string('comprobante_serie', 10)->nullable()->after('cliente_direccion');
            $table->unsignedInteger('comprobante_numero')->nullable()->after('comprobante_serie');

            // Estado de la emision ante SUNAT (a traves de Nubefact)
            $table->enum('estado_sunat', ['no_aplica', 'pendiente', 'aceptado', 'error'])
                ->default('no_aplica')
                ->after('comprobante_numero');

            // Resultado de Nubefact
            $table->string('enlace_pdf')->nullable()->after('estado_sunat');
            $table->string('enlace_xml')->nullable()->after('enlace_pdf');
            $table->string('enlace_cdr')->nullable()->after('enlace_xml');
            $table->string('hash_sunat')->nullable()->after('enlace_cdr');
            $table->text('sunat_mensaje')->nullable()->after('hash_sunat'); // mensaje de error o descripcion de SUNAT
            $table->json('sunat_respuesta')->nullable()->after('sunat_mensaje'); // respuesta cruda de Nubefact, por si se necesita depurar

            // Referencia a un comprobante anterior (para notas de credito/debito, se usa en fase 4)
            $table->foreignId('comprobante_referencia_id')->nullable()->after('sunat_respuesta')
                ->constrained('sales')->nullOnDelete();

            $table->index(['tipo_comprobante', 'estado_sunat']);
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropConstrainedForeignId('comprobante_referencia_id');
            $table->dropIndex(['tipo_comprobante', 'estado_sunat']);
            $table->dropColumn([
                'tipo_comprobante',
                'cliente_tipo_documento',
                'cliente_numero_documento',
                'cliente_denominacion',
                'cliente_direccion',
                'comprobante_serie',
                'comprobante_numero',
                'estado_sunat',
                'enlace_pdf',
                'enlace_xml',
                'enlace_cdr',
                'hash_sunat',
                'sunat_mensaje',
                'sunat_respuesta',
            ]);
        });
    }
};
