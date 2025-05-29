<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EducationalBackground>
 */
class EducationalBackgroundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'university_id' => rand(1, 10),
            'degree_id' => rand(1, 10),
            'year_graduated' => $this->faker->year(),
            'honor' => $this->faker->randomDigitNotNull(),
        ];
    }
}
