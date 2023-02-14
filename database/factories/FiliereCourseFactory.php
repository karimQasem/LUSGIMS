<?php

namespace Database\Factories;

use App\Models\Cours;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FiliereCourse>
 */
class FiliereCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'filiere_id' => Filiere::factory(),
            'cours_id' => Cours::factory(),
        ];
    }
}
