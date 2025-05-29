<?php

namespace Database\Seeders;

use App\Models\EducationalBackground;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationalBackgroundSeeder extends Seeder
{

    public function run(): void
    {
        foreach (range(1, 200) as $graduateId) {
            EducationalBackground::factory()->create([
                'graduate_id' => $graduateId,
            ]);
        }
    }
}
