<?php

namespace Database\Factories;

use App\Models\ResearchProject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ResearchProject>
 */
class ResearchProjectFactory extends Factory
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
            'slug' => Str::slug($title),

            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(),

            'status' => fake()->randomElement([
                'planned',
                'ongoing',
                'completed',
                'archived',
            ]),

            'start_date' => fake()->date(),
            'end_date' => fake()->optional()->date(),

            'location' => fake()->city(),
            'funding_source' => fake()->company(),

            'featured_image' => null,

            'created_by' => null,
        ];
    }
}
