<?php

namespace Database\Factories;

use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $positionId = $this->faker->numberBetween(1, 10);
        $positionId == 1 ? $name = $this->faker->firstNameMale() : ($positionId == 3 ? $name = $this->faker->firstNameMale() : ($positionId == 5 ? $name = $this->faker->firstNameMale() : ($positionId == 7 ? $name = $this->faker->firstNameMale() : ($positionId == 9 ? $name = $this->faker->firstNameMale() : $name = $this->faker->firstNameFemale()))));
        return [
            'family_id' => Family::all()->random()->id,
            'name' => $name,
            'position_id' => $positionId,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
}



