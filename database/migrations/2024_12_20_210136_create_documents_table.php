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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Company::class)->constrained();
            $table->unsignedBigInteger('type'); 
            $table->unsignedBigInteger('folio');
            $table->date('date');
            $table->string('title')->nullable();
            $table->string('order_number')->nullable();
            $table->foreignIdFor(App\Models\Entity::class)->nullable()->constrained();
            $table->foreignIdFor(App\Models\Warehouse::class)->nullable()->constrained();
            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('tax')->default(0);
            $table->bigInteger('total')->default(0);
            $table->string('status');
            $table->uuid('uuid')->nullable()->unique();
            $table->string('external_model')->nullable();
            $table->unsignedBigInteger('external_id')->nullable();
            $table->foreignIdFor(App\Models\User::class)->constrained();
            $table->timestamps();

            $table->unique(['company_id', 'type', 'folio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
