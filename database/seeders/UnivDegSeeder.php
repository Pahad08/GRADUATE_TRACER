<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\HEI;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnivDegSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universities = [
            'Notre Dame of Marbel University',
            'University of Southern Mindanao',
            'South Cotabato State College',
            'Sultan Kudarat State University',
            'General Santos City National School of Arts and Trades',
            'Mindanao State University - General Santos',
            'University of Kidapawan',
            'Ramon Magsaysay Memorial Colleges',
            'Cotabato City State Polytechnic College',
            'Tacurong College'
        ];
        foreach ($universities as $university) {
            HEI::create([
                'hei_name' => $university,
            ]);
        }

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

        foreach ($degrees as $degree) {
            Degree::create([
                'degree_name' => $degree,
            ]);
        }
    }
}
