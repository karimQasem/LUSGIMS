<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cours;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\FiliereCourse;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            StudentSeeder::class,
            CoursSeeder::class,
            EnrollmentSeeder::class,
            ExamSeeder::class,
            FiliereSeeder::class,
            FiliereCourseSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class
        ]);
    }
}
