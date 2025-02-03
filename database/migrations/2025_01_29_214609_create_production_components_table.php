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
        Schema::create('production_components', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Production::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Product::class, 'component_id')->constrained();
            $table->bigInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_components');
    }
};
