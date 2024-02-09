<?php

use App\Models\ThailandAddr;
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
        Schema::create('thailand_addrs', function (Blueprint $table) {
            $table->id();
            $table->string('Tambon');
            $table->string('District');
            $table->string('Province');
            $table->timestamps();
        });
        //seed data
        $csvFile = fopen(base_path("database/data/ThaiTambon.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                ThailandAddr::create([
                    "id" => $data['0'],
                    "Tambon" => $data['1'],
                    "District" => $data['6'],
                    "Province" => $data['11']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thailand_addrs');
    }
};
