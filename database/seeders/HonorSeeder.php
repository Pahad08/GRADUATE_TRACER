<?php

namespace Database\Seeders;

use App\Models\EducationalBackground;
use App\Models\Honor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 200) as $graduateId) {
            if (!EducationalBackground::find($graduateId)) {
                continue;
            }

            Honor::factory()
                ->create(['educational_background_id' => $graduateId]);
        }
    }
}
