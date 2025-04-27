<?php

namespace Database\Factories;

use App\Models\Degree;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DegreesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Degree::class;

    public function definition(): array
    {
        $degrees = [
            'Bachelor of Science in Accountancy',
            'Bachelor of Science in Nursing',
            'Bachelor of Science in Information Technology',
            'Bachelor of Science in Business Administration',
            'Bachelor of Science in Psychology',
            'Bachelor of Arts in Communication',
            'Bachelor of Science in Civil Engineering',
            'Bachelor of Science in Computer Science',
            'Bachelor of Fine Arts',
            'Bachelor of Science in Pharmacy'
        ];

        return [
            'degree_name' => $this->faker->randomElement($degrees),
        ];
    }
}
