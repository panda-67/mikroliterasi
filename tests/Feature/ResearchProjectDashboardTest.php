<?php

namespace Tests\Feature;

use App\Models\ResearchProject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResearchProjectDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_research_project_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        ResearchProject::factory()->count(2)->create([
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('dashboard.research-projects.index'));

        $response->assertOk();
        $response->assertViewIs('dashboard.research-projects.index');
        $response->assertViewHas('projects');
    }

    public function test_editor_can_view_research_project_dashboard(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $response = $this->actingAs($editor)
            ->get(route('dashboard.research-projects.index'));

        $response->assertOk();
        $response->assertViewIs('dashboard.research-projects.index');
    }

    public function test_researcher_cannot_view_research_project_dashboard(): void
    {
        $researcher = User::factory()->create([
            'role' => 'researcher',
        ]);

        $response = $this->actingAs($researcher)
            ->get(route('dashboard.research-projects.index'));

        $response->assertForbidden();
    }

    public function test_guest_cannot_view_research_project_dashboard(): void
    {
        $response = $this->get(route('dashboard.research-projects.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_create_project_from_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('research-projects.create', [
                'fromDashboard' => 1,
            ]));

        $response->assertOk();
        $response->assertViewIs('research-projects.create');
        $response->assertViewHas('fromDashboard', true);
    }

    public function test_admin_can_edit_project_from_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $project = ResearchProject::factory()->create([
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('research-projects.edit', [
                'research_project' => $project,
                'fromDashboard' => 1,
            ]));

        $response->assertOk();
        $response->assertViewIs('research-projects.edit');
        $response->assertViewHas('fromDashboard', true);
    }

    public function test_admin_can_delete_project_from_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $project = ResearchProject::factory()->create([
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->delete(
                route('research-projects.destroy', $project),
                [
                    'fromDashboard' => 1,
                ]
            );

        $response->assertRedirect(
            route('dashboard.research-projects.index')
        );

        $response->assertSessionHas(
            'success',
            'Research project berhasil dihapus.'
        );

        $this->assertDatabaseMissing(
            'research_projects',
            ['id' => $project->id]
        );
    }

    public function test_editor_cannot_delete_project_from_dashboard(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $project = ResearchProject::factory()->create();

        $response = $this->actingAs($editor)
            ->delete(
                route('research-projects.destroy', $project),
                [
                    'fromDashboard' => 1,
                ]
            );

        $response->assertForbidden();

        $this->assertDatabaseHas(
            'research_projects',
            ['id' => $project->id]
        );
    }
}
