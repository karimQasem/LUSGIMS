<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name'=>fake()->name(),
            'last_name'=>fake()->lastName(),
            'specialty'=>fake()->word(),
            'phone_number'=>fake()->e164PhoneNumber(),
            'email'=>fake()->unique()->safeEmail(),
            'user_id'=>User::factory(),
        ];
    }
}
