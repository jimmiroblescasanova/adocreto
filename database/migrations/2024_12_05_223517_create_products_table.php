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
            $table->unsignedBigInteger('type'); // 1: Material, 2: PT, 3: Service
            $table->string('code');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->foreignIdFor(App\Models\Unit::class)->constrained();
            $table->foreignIdFor(App\Models\Category::class)->nullable()->constrained();
            $table->unsignedBigInteger('minimum')->default(0);
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
