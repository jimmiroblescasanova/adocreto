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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Company::class);
            $table->unsignedBigInteger('type'); // 1: Materia Prima, 2: Producto, 3: Servicio, 4: Producto Compuesto
            $table->string('code');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->foreignIdFor(App\Models\Unit::class)->constrained();
            $table->foreignIdFor(App\Models\Category::class)->nullable()->constrained();
            $table->unsignedBigInteger('production_conversion_quantity')->nullable();
            $table->foreignIdFor(App\Models\Unit::class, 'production_unit_id')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
