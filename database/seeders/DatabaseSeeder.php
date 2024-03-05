<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'master',
            'email' => 'maggotgluon@gmail.com',
            'password'=>'gto3000gt',
            'isAdmin'=>true
        ]);
        // \App\Models\User::factory(10)->create();
        // \App\Models\client::factory(10)->create();
    }
}
