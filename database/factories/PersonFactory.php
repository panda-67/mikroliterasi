<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name),

            'photo' => null,

            'position' => fake()->randomElement([
                'Researcher',
                'Field Researcher',
                'Research Coordinator',
                'Research Assistant',
                'Lecturer',
            ]),

            'short_bio' => fake()->sentence(),

            'bio' => fake()->paragraphs(2, true),

            'email' => fake()->safeEmail(),

            'website' => fake()->optional()->url(),

            'scopus' => fake()->optional()->url(),

            'google_scholar' => fake()->optional()->url(),

            'orcid' => fake()->optional()->url(),

            'sinta' => fake()->optional()->url(),

            'education' => fake()->sentence(),

            'research_interests' => fake()->sentence(),

            'status' => fake()->randomElement([
                'active',
                'active',
                'active',
                'inactive',
            ]),
        ];
    }
}
