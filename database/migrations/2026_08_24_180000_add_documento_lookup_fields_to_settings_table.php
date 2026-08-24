<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('documento_api_proveedor')->default('apisnet')
                ->comment('Proveedor de consulta DNI/RUC: apisnet, apisperu, personalizado');
            $table->string('documento_api_token')->nullable()
                ->comment('Token del proveedor de consulta DNI/RUC (editable desde Ajustes)');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['documento_api_proveedor', 'documento_api_token']);
        });
    }
};
