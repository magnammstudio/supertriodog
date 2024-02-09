<?php

namespace Database\Factories;

use App\Models\vet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'client_code'=>fake()->unique()->numberBetween(9000,9999999),

            'name'=>fake()->name(),
            'email'=>fake()->safeEmail(),
            'phone'=>fake()->unique()->phoneNumber(),
            'phoneIsVerified'=>fake()->numberBetween(1000,9000),

            'pet_name'=>fake()->name(),
            'pet_breed'=>fake()->company(),
            'pet_weight'=>fake()->numberBetween(1,10),
            'pet_age_month'=>fake()->numberBetween(1,10),
            'pet_age_year'=>fake()->numberBetween(1,10),
            'option_1'=>fake()->randomElement([0,1]),
            'option_2'=>fake()->randomElement([0,1]),
            'option_3'=>fake()->randomElement([0,3,6,9]),

            'vet_id'=>fake()->randomElement(vet::pluck('id')->toArray()),
            'active_date'=>fake()->date(),
            'active_status'=>fake()->date()
        ];
    }
}
