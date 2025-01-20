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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Company::class)->constrained();
            $table->foreignIdFor(App\Models\User::class)->constrained();
            $table->foreignIdFor(App\Models\Warehouse::class, 'origin_warehouse_id')->constrained();
            $table->foreignIdFor(App\Models\Warehouse::class, 'destination_warehouse_id')->constrained();
            $table->unsignedBigInteger('folio');
            $table->dateTime('date');
            $table->string('title');
            $table->uuid('uuid')->nullable()->unique();
            $table->timestamps();

            $table->unique(['company_id', 'folio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
