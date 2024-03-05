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
        Schema::create('rmkt_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('vet_id');
            $table->integer('option_1')->nullable();
            $table->integer('option_2')->nullable();
            $table->integer('option_3')->nullable();
            $table->dateTime('active_date')->nullable();
            $table->string('active_status')->nullable();
            $table->json('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rmkt_clients');
    }
};
