<?php

namespace Database\Factories;

use App\Models\ResearchArea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ResearchArea>
 */
class ResearchAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Biodiversity Conservation',
            'Forest Ecology',
            'Wildlife Conservation',
            'Landscape Ecology',
            'Ecology and Biodiversity',
            'Sustainable Forest Management',
            'Human-Wildlife Conflict',
            'GIS and Remote Sensing',
            'Species Conservation',
            'Habitat and Corridor Ecology',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
        ];
    }
}
