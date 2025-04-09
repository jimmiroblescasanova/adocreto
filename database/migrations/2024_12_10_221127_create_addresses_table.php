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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            $table->unsignedBigInteger('type'); // 1: billing, 2: shipping
            $table->string('street');
            $table->string('exterior')->nullable();
            $table->string('interior')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('zip')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->longText('notes')->nullable();
            $table->string('address_line_1')->storedAs('CONCAT(street, " ", exterior, " ", interior, ", ", neighborhood)');
            $table->string('address_line_2')->storedAs('CONCAT(city, ", ", state, ", ", country, " ", zip)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
