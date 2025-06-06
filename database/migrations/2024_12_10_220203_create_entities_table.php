<?php

use App\Models\Cfdi40\RegimenFiscal;
use App\Models\Cfdi40\UsoCfdi;
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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Company::class)->constrained();
            $table->unsignedBigInteger('type'); // 1: Client, 2: Provider
            $table->unsignedBigInteger('code');
            $table->string('name');
            $table->string('rfc')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('active')->default(true);
            $table->longText('notes')->nullable();
            $table->foreignIdFor(RegimenFiscal::class)->nullable();
            $table->foreignIdFor(UsoCfdi::class)->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'type', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
