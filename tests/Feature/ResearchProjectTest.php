<?php

namespace Tests\Feature;

use App\Models\ResearchProject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResearchProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_research_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('research-projects.store'),
            [
                'title' => 'Mapping Sumatran Elephant Corridors',
                'short_description' => 'Research project description.',
                'description' => 'Full research project description.',
                'status' => 'planned',
                'start_date' => '2026-10-01',
                'end_date' => '2027-10-01',
                'location' => 'Aceh',
                'funding_source' => 'Research Grant',
            ]
        );

        $project = ResearchProject::first();

        $response
            ->assertRedirect(
                route('research-projects.show', $project->slug)
            )
            ->assertSessionHas(
                'success',
                'Research project berhasil dibuat.'
            );

        $this->assertDatabaseHas('research_projects', [
            'title' => 'Mapping Sumatran Elephant Corridors',
            'slug' => 'mapping-sumatran-elephant-corridors',
        ]);
    }

    public function test_create_requires_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('research-projects.store'),
            [
                'status' => 'planned',
            ]
        );

        $response
            ->assertRedirect()
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('research_projects', 0);
    }

    public function test_create_rejects_invalid_status(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('research-projects.store'),
            [
                'title' => 'Invalid Project',
                'status' => 'invalid-status',
            ]
        );

        $response
            ->assertRedirect()
            ->assertSessionHasErrors('status');

        $this->assertDatabaseCount('research_projects', 0);
    }

    public function test_create_rejects_end_date_before_start_date(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('research-projects.store'),
            [
                'title' => 'Date Validation Test',
                'status' => 'planned',
                'start_date' => '2027-01-01',
                'end_date' => '2026-01-01',
            ]
        );

        $response
            ->assertRedirect()
            ->assertSessionHasErrors('end_date');

        $this->assertDatabaseCount('research_projects', 0);
    }

    public function test_authenticated_user_can_update_research_project(): void
    {
        $user = User::factory()->create();

        $project = ResearchProject::factory()->create([
            'title' => 'Original Project',
            'slug' => 'original-project',
            'status' => 'planned',
        ]);

        $response = $this->actingAs($user)->put(
            route('research-projects.update', $project->slug),
            [
                'title' => 'Updated Project',
                'short_description' => 'Updated short description.',
                'description' => 'Updated description.',
                'status' => 'ongoing',
                'start_date' => '2026-10-01',
                'end_date' => '2027-10-01',
                'location' => 'Aceh',
                'funding_source' => 'Updated Funding',
            ]
        );

        $response
            ->assertRedirect(
                route(
                    'research-projects.show',
                    'original-project'
                )
            )
            ->assertSessionHas(
                'success',
                'Research project berhasil diperbarui.'
            );

        $this->assertDatabaseHas('research_projects', [
            'id' => $project->id,
            'title' => 'Updated Project',
            'slug' => 'original-project',
            'status' => 'ongoing',
        ]);
    }

    public function test_update_validation_failure_does_not_change_project(): void
    {
        $user = User::factory()->create();

        $project = ResearchProject::factory()->create([
            'title' => 'Original Project',
            'slug' => 'original-project',
            'status' => 'planned',
        ]);

        $response = $this->actingAs($user)->put(
            route('research-projects.update', $project->slug),
            [
                'title' => '',
                'status' => 'planned',
            ]
        );

        $response
            ->assertRedirect()
            ->assertSessionHasErrors('title');

        $this->assertDatabaseHas('research_projects', [
            'id' => $project->id,
            'title' => 'Original Project',
            'slug' => 'original-project',
            'status' => 'planned',
        ]);
    }

    public function test_authenticated_user_can_delete_research_project(): void
    {
        $user = User::factory()->create();

        $project = ResearchProject::factory()->create([
            'slug' => 'project-to-delete',
        ]);

        $response = $this->actingAs($user)->delete(
            route(
                'research-projects.destroy',
                $project->slug
            )
        );

        $response
            ->assertRedirect(
                route('research-projects.index')
            )
            ->assertSessionHas(
                'success',
                'Research project berhasil dihapus.'
            );

        $this->assertDatabaseMissing('research_projects', [
            'id' => $project->id,
        ]);
    }

    public function test_guest_cannot_create_research_project(): void
    {
        $response = $this->post(
            route('research-projects.store'),
            [
                'title' => 'Unauthorized Project',
                'status' => 'planned',
            ]
        );

        $response->assertRedirect();

        $this->assertDatabaseCount('research_projects', 0);
    }
}
