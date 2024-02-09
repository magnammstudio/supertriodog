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
        Schema::create('vets', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('vet_name');
            $table->string('vet_province');
            $table->string('vet_city');
            $table->string('vet_area');
            $table->text('vet_remark')->nullable();
            $table->foreignUuid('user_id')->nullable();
            $table->foreignUuid('stock_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vets');
    }
};
