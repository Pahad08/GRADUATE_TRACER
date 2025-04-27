<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Graduate>
 */
class GraduateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'f_name' => $this->faker->firstName(),
            'l_name' => $this->faker->lastName(),
            'permanent_address' => $this->faker->address(),
            'email_address' => $this->faker->email(),
            'contact_number' => $this->faker->phoneNumber(),
            'civil_status' => $this->faker->randomElement(['single', 'married', 'separated', 'single parent', 'widow']),
            'sex' => $this->faker->randomElement(['male', 'female']),
            'birthdate' => $this->faker->date(),
            'location_of_residence' => $this->faker->randomElement(['city', 'municipality']),
            'region_id' => 1,
            'province_id' => $this->faker->randomElement([1, 2, 3, 4]),
        ];
    }
}
