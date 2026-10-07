<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\ResearchProject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(fake()->numberBetween(5, 10));

        $status = fake()->randomElement([
            'draft',
            'published',
            'archived',
        ]);

        return [
            'title' => $title,

            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 999999),

            'excerpt' => fake()->paragraph(),

            'content' => fake()->paragraphs(
                fake()->numberBetween(3, 7),
                true
            ),

            'category' => fake()->randomElement([
                'research_update',
                'publication',
                'field_activity',
                'institutional',
                'announcement',
            ]),

            'featured_image' => null,

            'published_at' => $status === 'draft'
                ? null
                : fake()->dateTimeBetween(
                    '-1 year',
                    'now'
                ),

            'status' => $status,

            'author_id' => User::factory(),

            'research_project_id' => fake()->boolean(70)
                ? ResearchProject::factory()
                : null,
        ];
    }

    public function published(): static
    {
        return $this->state(function () {
            return [
                'status' => 'published',
                'published_at' => fake()->dateTimeBetween(
                    '-1 year',
                    'now'
                ),
            ];
        });
    }

    public function draft(): static
    {
        return $this->state([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function archived(): static
    {
        return $this->state(function () {
            return [
                'status' => 'archived',
                'published_at' => fake()->dateTimeBetween(
                    '-1 year',
                    'now'
                ),
            ];
        });
    }
}
