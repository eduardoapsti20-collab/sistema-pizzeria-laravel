<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // documento_api_token pasa a usarse solo para RUC (decolecta.com).
            // La consulta publica de DNI fue descontinuada por decolecta/apis.net.pe,
            // asi que DNI necesita un proveedor de pago aparte (ej. apidni.com).
            $table->string('dni_api_token')->nullable()
                ->comment('Token del proveedor de consulta de DNI (ej. apidni.com), separado del de RUC');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('dni_api_token');
        });
    }
};
