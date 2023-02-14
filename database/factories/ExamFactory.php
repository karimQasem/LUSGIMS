<?php

namespace Database\Factories;

use App\Models\Cours;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        'cours_id' => Cours::factory(),
        'exam_date'=>fake()->dateTime(),
        'teacher_id' => Teacher::factory(),
        ];
    }
}
