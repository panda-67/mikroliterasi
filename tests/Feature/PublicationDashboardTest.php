<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_publication_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        Publication::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('dashboard.publications.index'));

        $response->assertOk();
        $response->assertViewIs('dashboard.publications.index');
        $response->assertViewHas('publications');
    }

    public function test_editor_can_view_publication_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'editor',
        ]);

        $response = $this->actingAs($user)
            ->get(route('dashboard.publications.index'));

        $response->assertOk();
        $response->assertViewIs('dashboard.publications.index');
    }

    public function test_researcher_cannot_view_publication_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'researcher',
        ]);

        $response = $this->actingAs($user)
            ->get(route('dashboard.publications.index'));

        $response->assertForbidden();
    }

    public function test_guest_cannot_view_publication_dashboard(): void
    {
        $response = $this->get(route('dashboard.publications.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_open_publication_create_from_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)
            ->get(route('publications.create', [
                'fromDashboard' => 1,
            ]));

        $response->assertOk();
        $response->assertViewIs('publications.create');
        $response->assertViewHas('fromDashboard', true);
    }

    public function test_admin_can_open_publication_edit_from_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $publication = Publication::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('publications.edit', [
                'publication' => $publication,
                'fromDashboard' => 1,
            ]));

        $response->assertOk();
        $response->assertViewIs('publications.edit');
        $response->assertViewHas('publication', $publication);
    }

    public function test_admin_can_delete_publication(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $publication = Publication::factory()->create();

        $response = $this->actingAs($user)
            ->delete(
                route('publications.destroy', $publication),
                [
                    'fromDashboard' => 1,
                ]
            );

        $response->assertRedirect(route('dashboard.publications.index'));

        $this->assertDatabaseMissing('publications', [
            'id' => $publication->id,
        ]);
    }

    public function test_editor_cannot_delete_publication(): void
    {
        $user = User::factory()->create([
            'role' => 'editor',
        ]);

        $publication = Publication::factory()->create();

        $response = $this->actingAs($user)
            ->delete(
                route('publications.destroy', $publication)
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('publications', [
            'id' => $publication->id,
        ]);
    }

    public function test_admin_can_store_publication_from_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)
            ->post(
                route('publications.store'),
                [
                    'title' => 'Test Publication From Dashboard',
                    'publication_type' => 'journal_article',
                    'year' => 2026,
                    'fromDashboard' => 1,
                    'people' => [],
                    'research_projects' => [],
                ]
            );

        $publication = Publication::query()
            ->where('title', 'Test Publication From Dashboard')
            ->first();

        $this->assertNotNull($publication);

        $response->assertRedirect(
            route('dashboard.publications.index')
        );

        $response->assertSessionHas(
            'success',
            'Publication berhasil dibuat.'
        );
    }

    public function test_admin_can_update_publication_from_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $publication = Publication::factory()->create([
            'title' => 'Original Publication Title',
        ]);

        $response = $this->actingAs($user)
            ->put(
                route('publications.update', $publication),
                [
                    'title' => 'Updated Publication From Dashboard',
                    'publication_type' => 'journal_article',
                    'year' => 2026,
                    'fromDashboard' => 1,
                    'people' => [],
                    'research_projects' => [],
                ]
            );

        $response->assertRedirect(
            route('dashboard.publications.index')
        );

        $response->assertSessionHas(
            'success',
            'Publication berhasil diperbarui.'
        );

        $this->assertDatabaseHas('publications', [
            'id' => $publication->id,
            'title' => 'Updated Publication From Dashboard',
            'publication_type' => 'journal_article',
        ]);
    }
}
