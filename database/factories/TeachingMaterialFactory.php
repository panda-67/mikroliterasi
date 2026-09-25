<?php

namespace Database\Factories;

use App\Models\TeachingMaterial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeachingMaterial>
 */
class TeachingMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => str()->slug($title),
            'description' => fake()->paragraph(),
            'ppt_url' => 'https://drive.google.com/',
            'created_by' => User::factory(),
        ];
    }
}
