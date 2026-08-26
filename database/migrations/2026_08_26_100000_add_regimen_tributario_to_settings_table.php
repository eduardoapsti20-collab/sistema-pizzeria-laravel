<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->enum('regimen_tributario', ['nuevo_rus', 'general_mype'])
                ->default('general_mype')
                ->comment('Nuevo RUS: solo boletas, sin desglose de IGV. General/MYPE: boleta y factura con IGV 18%');
        });

        // Deja configurada la fila existente segun lo confirmado en la consulta RUC real del negocio.
        DB::table('settings')->update(['regimen_tributario' => 'nuevo_rus']);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('regimen_tributario');
        });
    }
};
