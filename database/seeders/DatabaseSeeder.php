<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\stock;
use App\Models\User;
use App\Models\vet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\client::factory(10)->create();

        $pwd = Hash::make('catPlus');

        \App\Models\User::factory()->create([
            'name' => 'master',
            'email' => 'maggotgluon@gmail.com',
            'password'=>'gto3000gt',
            'isAdmin'=>true
        ]);
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin',
            'password'=>$pwd,
            'isAdmin'=>true
        ]);

        $csvFile = fopen(base_path("database/data/vet-Table.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                // $u = User::create([
                //     "id" => $data['1'],
                //     "name" => $data['3'],
                //     "email" => $data['1'],
                //     'email_verified_at' => now(),
                //     "password"=> Hash::make($data['1']),
                //     'remember_token' => 'generatedatafromvettable',
                // ]);
                $u = vet::create([
                    "id" => $data['1'],
                    "vet_name" => $data['3'],
                    "vet_province" => $data['6'],
                    "vet_city" => $data['5'],
                    "vet_area" => $data['4'],
                    // "user_id" => $data['1'],
                    "stock_id" => $data['1'],
                ]);
                $s = stock::create([
                    "id" => $data['1'],
                    "total_stock" => 0,
                    "stock_adj" => 0,
                ]);
                //print($u->id.$u->name);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
