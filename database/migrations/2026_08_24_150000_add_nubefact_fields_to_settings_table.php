<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('nubefact_ruta')->nullable()->comment('URL de la API de Nubefact para tu empresa');
            $table->string('nubefact_token')->nullable()->comment('Token secreto de autenticacion Nubefact');
            $table->string('nubefact_ambiente')->default('demo')->comment('demo o produccion');
            $table->string('nubefact_serie_boleta')->default('B001');
            $table->string('nubefact_serie_factura')->default('F001');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'nubefact_ruta',
                'nubefact_token',
                'nubefact_ambiente',
                'nubefact_serie_boleta',
                'nubefact_serie_factura',
            ]);
        });
    }
};
