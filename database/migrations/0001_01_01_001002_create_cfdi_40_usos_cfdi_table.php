<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cfdi_40_usos_cfdi', function (Blueprint $table) {
            $table->id();
            $table->string('clave'); // Texto como clave primaria
            $table->string('descripcion', 255); // Texto descriptivo
            $table->boolean('aplica_fisica'); // 1 para true, 0 para false
            $table->boolean('aplica_moral'); // 1 para true, 0 para false
            $table->string('vigencia_desde')->nullable(); // Texto para la fecha inicial
            $table->string('vigencia_hasta')->nullable(); // Texto para la fecha final
            $table->json('regimenes_fiscales_receptores'); // Texto para almacenar los valores
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cfdi_40_usos_cfdi');
    }
};
