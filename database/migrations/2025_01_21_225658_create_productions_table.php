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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Company::class);
            $table->unsignedBigInteger('folio')->unique();
            $table->date('date');
            $table->string('title');
            $table->string('status');
            $table->foreignIdFor(App\Models\User::class)->constrained();
            $table->foreignIdFor(App\Models\Warehouse::class, 'origin_warehouse_id')->constrained();
            $table->foreignIdFor(App\Models\Warehouse::class, 'destination_warehouse_id')->constrained();
            $table->foreignIdFor(App\Models\User::class, 'started_by')->nullable()->constrained();
            $table->dateTime('started_at')->nullable();
            $table->foreignIdFor(App\Models\User::class, 'ended_by')->nullable()->constrained();
            $table->dateTime('ended_at')->nullable();
            $table->uuid();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
