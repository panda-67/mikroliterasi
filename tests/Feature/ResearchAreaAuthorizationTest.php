<?php

namespace Tests\Feature;

use App\Models\ResearchArea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResearchAreaAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_research_areas(): void
    {
        $response = $this->get(
            route('dashboard.research-areas.index')
        );

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_research_areas(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('dashboard.research-areas.index'));

        $response->assertOk();
    }

    public function test_editor_can_view_research_areas(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $response = $this
            ->actingAs($editor)
            ->get(route('dashboard.research-areas.index'));

        $response->assertOk();
    }

    public function test_editor_cannot_create_research_area(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $response = $this
            ->actingAs($editor)
            ->get(route('dashboard.research-areas.create'));

        $response->assertForbidden();
    }

    public function test_editor_cannot_update_research_area(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $researchArea = ResearchArea::factory()->create();

        $response = $this
            ->actingAs($editor)
            ->put(
                route(
                    'dashboard.research-areas.update',
                    $researchArea
                ),
                [
                    'name' => 'Updated Research Area',
                    'slug' => 'updated-research-area',
                    'description' => 'Updated description.',
                ]
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('research_areas', [
            'id' => $researchArea->id,
            'name' => $researchArea->name,
        ]);
    }

    public function test_editor_cannot_delete_research_area(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $researchArea = ResearchArea::factory()->create();

        $response = $this
            ->actingAs($editor)
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
}
