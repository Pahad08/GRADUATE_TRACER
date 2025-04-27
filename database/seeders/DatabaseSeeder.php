<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Province;
use App\Models\Region;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            Degree::create(['degree_name' => 'Bachelor of Science in Information Systems']);
            Region::create(['region_name' => 'REGION 12']);
            University::create(['university_name' => 'Sultan Kudarat State University']);

            $provinces = [
                ['province_name' => 'SULTAN KUDARAT'],
                ['province_name' =>  'SOUTH COTABATO'],
                ['province_name' => 'SARANGANI'],
                ['province_name' =>  'COTABATO'],
            ];
            foreach ($provinces as $province) {
                Province::create($province);
            }
        });
    }
}
