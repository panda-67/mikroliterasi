<?php

namespace Tests\Feature\Dashboard;

use App\Models\ResearchArea;
use App\Models\ResearchProject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResearchAreaDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_research_area_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        ResearchArea::factory()->create([
            'name' => 'Microbiology Education',
            'slug' => 'microbiology-education',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('dashboard.research-areas.index'));

        $response->assertOk();
        $response->assertViewIs('dashboard.research-areas.index');
        $response->assertSee('Microbiology Education');
    }

    public function test_editor_can_view_research_area_dashboard(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $response = $this->actingAs($editor)
            ->get(route('dashboard.research-areas.index'));

        $response->assertOk();
    }

    public function test_researcher_cannot_view_research_area_dashboard(): void
    {
        $researcher = User::factory()->create([
            'role' => 'researcher',
        ]);

        $response = $this->actingAs($researcher)
            ->get(route('dashboard.research-areas.index'));

        $response->assertForbidden();
    }

    public function test_guest_cannot_view_research_area_dashboard(): void
    {
        $response = $this->get(route('dashboard.research-areas.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_create_research_area_with_automatic_slug(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('dashboard.research-areas.store'), [
                'name' => 'Microbiology Education',
                'description' => 'Research related to microbiology education.',
            ]);

        $response
            ->assertRedirect(route('dashboard.research-areas.index'));

        $this->assertDatabaseHas('research_areas', [
            'name' => 'Microbiology Education',
            'slug' => 'microbiology-education',
            'description' => 'Research related to microbiology education.',
        ]);
    }

    public function test_research_area_slug_is_unique(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        ResearchArea::factory()->create([
            'name' => 'Microbiology Education',
            'slug' => 'microbiology-education',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('dashboard.research-areas.store'), [
                'name' => 'Microbiology Education',
                'description' => 'Another research area.',
            ]);

        $response
            ->assertRedirect(route('dashboard.research-areas.index'));

        $this->assertDatabaseHas('research_areas', [
            'name' => 'Microbiology Education',
            'slug' => 'microbiology-education-1',
        ]);
    }

    public function test_admin_can_update_research_area(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $researchArea = ResearchArea::factory()->create([
            'name' => 'Wildlife Conservation',
            'slug' => 'wildlife-conservation',
            'description' => 'Original description.',
        ]);

        $response = $this->actingAs($admin)
            ->put(
                route(
                    'dashboard.research-areas.update',
                    $researchArea
                ),
                [
                    'name' => 'Wildlife and Conservation Biology',
                    'description' => 'Updated description.',
                ]
            );

        $response
            ->assertRedirect(route('dashboard.research-areas.index'));

        $this->assertDatabaseHas('research_areas', [
            'id' => $researchArea->id,
            'name' => 'Wildlife and Conservation Biology',
            'slug' => 'wildlife-conservation',
            'description' => 'Updated description.',
        ]);
    }

    public function test_research_area_slug_is_immutable(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $researchArea = ResearchArea::factory()->create([
            'name' => 'Wildlife Conservation',
            'slug' => 'wildlife-conservation',
        ]);

        $this->actingAs($admin)
            ->put(
                route(
                    'dashboard.research-areas.update',
                    $researchArea
                ),
                [
                    'name' => 'Forest Conservation',
                    'description' => 'Updated description.',
                    'slug' => 'forest-conservation',
                ]
            )
            ->assertRedirect(route('dashboard.research-areas.index'));

        $this->assertDatabaseHas('research_areas', [
            'id' => $researchArea->id,
            'name' => 'Forest Conservation',
            'slug' => 'wildlife-conservation',
        ]);

        $this->assertDatabaseMissing('research_areas', [
            'id' => $researchArea->id,
            'slug' => 'forest-conservation',
        ]);
    }

    public function test_editor_cannot_create_research_area(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $response = $this->actingAs($editor)
            ->post(route('dashboard.research-areas.store'), [
                'name' => 'Microbiology Education',
                'description' => 'Test description.',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('research_areas', [
            'name' => 'Microbiology Education',
        ]);
    }

    public function test_editor_cannot_update_research_area(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $researchArea = ResearchArea::factory()->create([
            'name' => 'Wildlife Conservation',
            'slug' => 'wildlife-conservation',
        ]);

        $response = $this->actingAs($editor)
            ->put(
                route(
                    'dashboard.research-areas.update',
                    $researchArea
                ),
                [
                    'name' => 'Forest Conservation',
                    'description' => 'Updated description.',
                ]
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('research_areas', [
            'id' => $researchArea->id,
            'name' => 'Wildlife Conservation',
            'slug' => 'wildlife-conservation',
        ]);
    }

    public function test_admin_can_delete_unused_research_area(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $researchArea = ResearchArea::factory()->create();

        $response = $this->actingAs($admin)
            ->delete(
                route(
                    'dashboard.research-areas.destroy',
                    $researchArea
                )
            );

        $response
            ->assertRedirect(route('dashboard.research-areas.index'));

        $this->assertDatabaseMissing('research_areas', [
            'id' => $researchArea->id,
        ]);
    }

    public function test_editor_cannot_delete_research_area(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $researchArea = ResearchArea::factory()->create();

        $response = $this->actingAs($editor)
            ->delete(
                route(
                    'dashboard.research-areas.destroy',
                    $researchArea
                )
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('research_areas', [
            'id' => $researchArea->id,
        ]);
    }

    public function test_research_area_cannot_be_deleted_when_used_by_research_project(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $researchArea = ResearchArea::factory()->create();

        $researchProject = ResearchProject::factory()->create();

        $researchProject->researchAreas()->attach($researchArea);

        $response = $this->actingAs($admin)
            ->delete(
                route(
                    'dashboard.research-areas.destroy',
                    $researchArea
                )
            );

        $response
            ->assertRedirect();

        $response->assertSessionHas(
            'error',
            'Research area cannot be deleted because it is still used by research projects.'
        );

        $this->assertDatabaseHas('research_areas', [
            'id' => $researchArea->id,
        ]);
    }
}
