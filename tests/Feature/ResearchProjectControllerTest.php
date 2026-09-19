<?php

namespace Tests\Feature;

use App\Models\ResearchProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResearchProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_research_projects(): void
    {
        ResearchProject::factory()->create([
            'title' => 'Test Research Project',
            'slug' => 'test-research-project',
        ]);

        $response = $this->get(
            route('research-projects.index')
        );

        $response->assertStatus(200);
    }

    public function test_show_displays_research_project(): void
    {
        $project = ResearchProject::factory()->create([
            'title' => 'Test Research Project',
            'slug' => 'test-research-project',
        ]);

        $response = $this->get(
            route(
                'research-projects.show',
                $project
            )
        );

        $response->assertStatus(200);
    }

    public function test_store_creates_research_project(): void
    {
        $response = $this->post(
            route('research-projects.store'),
            [
                'title' => 'New Research Project',
                'slug' => 'new-research-project',
                'short_description' => 'Testing project creation.',
                'description' => 'Description for testing.',
                'status' => 'planned',
                'start_date' => '2026-09-19',
                'end_date' => '2027-09-19',
                'location' => 'Aceh',
                'funding_source' => 'Testing',
            ]
        );

        $response->assertRedirect();

        $this->assertDatabaseHas(
            'research_projects',
            [
                'title' => 'New Research Project',
                'slug' => 'new-research-project',
            ]
        );
    }

    public function test_update_updates_research_project(): void
    {
        $project = ResearchProject::factory()->create([
            'title' => 'Old Title',
            'slug' => 'old-title',
            'status' => 'planned',
        ]);

        $response = $this->put(
            route(
                'research-projects.update',
                $project
            ),
            [
                'title' => 'Updated Title',
                'slug' => 'updated-title',
                'short_description' => 'Updated description.',
                'description' => 'Updated project.',
                'status' => 'ongoing',
                'start_date' => '2026-09-19',
                'end_date' => '2027-09-19',
                'location' => 'Aceh',
                'funding_source' => 'Testing',
            ]
        );

        $response->assertRedirect();

        $this->assertDatabaseHas(
            'research_projects',
            [
                'id' => $project->id,
                'title' => 'Updated Title',
                'slug' => 'updated-title',
                'status' => 'ongoing',
            ]
        );
    }

    public function test_destroy_deletes_research_project(): void
    {
        $project = ResearchProject::factory()->create([
            'title' => 'Project To Delete',
            'slug' => 'project-to-delete',
        ]);

        $response = $this->delete(
            route(
                'research-projects.destroy',
                $project
            )
        );

        $response->assertRedirect(
            route('research-projects.index')
        );

        $this->assertDatabaseMissing(
            'research_projects',
            [
                'id' => $project->id,
            ]
        );
    }
}
