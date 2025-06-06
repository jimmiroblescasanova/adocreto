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
        Schema::create('document_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Document::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Product::class)->constrained();
            $table->foreignIdFor(App\Models\Warehouse::class)->nullable()->constrained();
            $table->bigInteger('quantity')->default(0);
            $table->bigInteger('price')->default(0);
            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('tax')->default(0);
            $table->bigInteger('total')->default(0);
            $table->integer('operation')->default(0); // 1: Entrada. -1: Salida. 0: No afecta.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
