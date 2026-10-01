<?php

namespace Database\Factories;

use App\Models\SiswaModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiswaModel>
 */
class SiswaModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nisn' => fake()->unique()->numerify('##########'),
        ];
    }
}
