<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\ResearchProject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::query()
            ->whereIn('role', ['admin', 'editor'])
            ->inRandomOrder()
            ->first();

        if (! $author) {
            $author = User::factory()->create([
                'role' => 'editor',
            ]);
        }

        $researchProject = ResearchProject::query()
            ->inRandomOrder()
            ->first();

        Post::factory()
            ->count(8)
            ->published()
            ->create([
                'author_id' => $author->id,
                'research_project_id' => $researchProject?->id,
            ]);

        Post::factory()
            ->count(3)
            ->draft()
            ->create([
                'author_id' => $author->id,
                'research_project_id' => $researchProject?->id,
            ]);

        Post::factory()
            ->count(2)
            ->archived()
            ->create([
                'author_id' => $author->id,
                'research_project_id' => $researchProject?->id,
            ]);
    }
}
