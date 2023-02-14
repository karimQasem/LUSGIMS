<?php

namespace Database\Factories;

use App\Models\Cours;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_id'=>Student::factory(),
            'cours_id'=>Cours::factory(),
            'semester'=>fake()->numberBetween(1, 2)
        ];
    }
}
