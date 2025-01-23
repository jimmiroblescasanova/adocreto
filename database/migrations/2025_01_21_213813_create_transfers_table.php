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
            $table->date('date');
            $table->unsignedBigInteger('folio');
            $table->string('title')->nullable();
            $table->foreignIdFor(App\Models\Warehouse::class, 'origin_warehouse_id')->constrained();
            $table->foreignIdFor(App\Models\Warehouse::class, 'destination_warehouse_id')->constrained();
            $table->foreignIdFor(App\Models\User::class, 'created_by')->constrained();
            $table->foreignIdFor(App\Models\User::class, 'accepted_by')->nullable()->constrained();
            $table->string('status');
            $table->uuid();
            $table->timestamps();
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
