<?php

namespace Database\Factories;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title),

            'publication_type' => fake()->randomElement([
                'journal_article',
                'conference_paper',
                'technical_report',
                'policy_brief',
                'thesis',
                'dataset',
            ]),

            'journal' => fake()->optional()->sentence(3),
            'publisher' => fake()->optional()->company(),

            'year' => fake()->numberBetween(
                now()->year - 10,
                now()->year
            ),

            'volume' => fake()->optional()->numberBetween(1, 20),
            'issue' => fake()->optional()->numberBetween(1, 12),
            'pages' => fake()->optional()->numerify('##-##'),

            'doi' => fake()->optional()->regexify(
                '10\.\d{4,9}/[-._;()/:A-Z0-9]+'
            ),

            'url' => fake()->optional()->url(),

            'abstract' => fake()->paragraphs(2, true),

            'file' => null,
        ];
    }
}
