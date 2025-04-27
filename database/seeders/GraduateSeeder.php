<?php

namespace Database\Seeders;

use App\Models\Graduate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GraduateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Graduate::factory()
            ->count(200)
            ->create();
    }
}
