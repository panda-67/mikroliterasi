<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\ResearchArea;
use App\Models\ResearchProject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_authenticated_user_can_upload_featured_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $image = UploadedFile::fake()->image('featured.jpg');

        $response = $this->actingAs($user)->post(
            route('research-projects.store'),
            [
                'title' => 'Elephant Corridor Research',
                'status' => 'ongoing',
                'featured_image' => $image,
            ]
        );

        $project = ResearchProject::first();

        $response->assertRedirect(
            route('research-projects.show', $project->slug)
        );

        $this->assertNotNull($project->featured_image);

        Storage::disk('public')->assertExists(
            $project->featured_image
        );
    }

    public function test_updating_featured_image_replaces_old_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $oldImage = UploadedFile::fake()->image('old.jpg');

        $project = ResearchProject::factory()->create([
            'title' => 'Elephant Corridor Research',
            'featured_image' => null,
        ]);

        $oldPath = $oldImage->store(
            'research-projects/featured',
            'public'
        );

        $project->update([
            'featured_image' => $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        $newImage = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($user)->put(
            route('research-projects.update', $project),
            [
                'title' => $project->title,
                'status' => $project->status,
                'featured_image' => $newImage,
            ]
        );

        $project->refresh();

        $response->assertRedirect(
            route('research-projects.show', $project->slug)
        );

        Storage::disk('public')->assertMissing($oldPath);

        $this->assertNotNull($project->featured_image);

        Storage::disk('public')->assertExists(
            $project->featured_image
        );

        $this->assertNotSame(
            $oldPath,
            $project->featured_image
        );
    }

    public function test_authenticated_user_can_create_research_project_with_research_areas(): void
    {
        $user = User::factory()->create();

        $areas = ResearchArea::factory()->count(3)->create();

        $response = $this
            ->actingAs($user)
            ->post(route('research-projects.store'), [
                'title' => 'Research Project with Areas',
                'short_description' => 'Short description',
                'description' => 'Project description',
                'status' => 'ongoing',
                'research_areas' => $areas->pluck('id')->toArray(),
            ]);

        $response->assertRedirect();

        $project = ResearchProject::where(
            'title',
            'Research Project with Areas'
        )->firstOrFail();

        $this->assertCount(3, $project->researchAreas);

        $this->assertDatabaseHas(
            'research_project_research_area',
            [
                'research_project_id' => $project->id,
                'research_area_id' => $areas[0]->id,
            ]
        );
    }

    public function test_authenticated_user_can_update_research_project_research_areas(): void
    {
        $user = User::factory()->create();

        $project = ResearchProject::factory()->create();

        $oldAreas = ResearchArea::factory()->count(2)->create();
        $newAreas = ResearchArea::factory()->count(3)->create();

        $project->researchAreas()->sync(
            $oldAreas->pluck('id')
        );

        $response = $this
            ->actingAs($user)
            ->put(
                route('research-projects.update', $project),
                [
                    'title' => $project->title,
                    'short_description' => $project->short_description,
                    'description' => $project->description,
                    'status' => $project->status,
                    'research_areas' => $newAreas->pluck('id')->toArray(),
                ]
            );

        $response->assertRedirect();

        $project->refresh();

        $this->assertCount(3, $project->researchAreas);

        foreach ($newAreas as $area) {
            $this->assertTrue(
                $project->researchAreas->contains($area)
            );
        }

        foreach ($oldAreas as $area) {
            $this->assertFalse(
                $project->researchAreas->contains($area)
            );
        }
    }

    public function test_research_project_can_have_publications(): void
    {
        $project = ResearchProject::factory()->create();

        $publications = Publication::factory()
            ->count(3)
            ->create();

        $project->publications()->sync(
            $publications->pluck('id')
        );

        $project->refresh();

        $this->assertCount(
            3,
            $project->publications
        );

        $this->assertEqualsCanonicalizing(
            $publications->pluck('id')->toArray(),
            $project->publications->pluck('id')->toArray()
        );
    }

    public function test_sync_publications_replaces_existing_publications(): void
    {
        $project = ResearchProject::factory()->create();

        $publications = Publication::factory()
            ->count(3)
            ->create();

        $service = app(
            \App\Services\ResearchProjectService::class
        );

        $service->syncPublications(
            $project,
            $publications->pluck('id')->toArray()
        );

        $project->refresh();

        $this->assertCount(
            3,
            $project->publications
        );

        $service->syncPublications(
            $project,
            [$publications[0]->id]
        );

        $project->refresh();

        $this->assertCount(
            1,
            $project->publications
        );

        $this->assertSame(
            $publications[0]->id,
            $project->publications->first()->id
        );
    }

    public function test_sync_publications_can_remove_all_publications(): void
    {
        $project = ResearchProject::factory()->create();

        $publications = Publication::factory()
            ->count(2)
            ->create();

        $service = app(
            \App\Services\ResearchProjectService::class
        );

        $service->syncPublications(
            $project,
            $publications->pluck('id')->toArray()
        );

        $service->syncPublications(
            $project,
            []
        );

        $project->refresh();

        $this->assertCount(
            0,
            $project->publications
        );
    }

    public function test_authenticated_user_can_create_research_project_with_publications(): void
    {
        $user = User::factory()->create();

        $publications = Publication::factory()
            ->count(3)
            ->create();

        $response = $this->actingAs($user)->post(
            route('research-projects.store'),
            [
                'title' => 'Elephant Corridor Research',
                'status' => 'ongoing',
                'publications' => $publications
                    ->pluck('id')
                    ->toArray(),
            ]
        );

        $project = ResearchProject::first();

        $response->assertRedirect(
            route('research-projects.show', $project->slug)
        );

        $this->assertCount(
            3,
            $project->fresh()->publications
        );

        $this->assertDatabaseCount(
            'research_project_publication',
            3
        );
    }

    public function test_authenticated_user_can_update_research_project_publications(): void
    {
        $user = User::factory()->create();

        $oldPublications = Publication::factory()
            ->count(2)
            ->create();

        $newPublications = Publication::factory()
            ->count(2)
            ->create();

        $project = ResearchProject::factory()->create([
            'title' => 'Elephant Corridor Research',
            'status' => 'ongoing',
        ]);

        $project->publications()->sync(
            $oldPublications->pluck('id')->toArray()
        );

        $response = $this->actingAs($user)->put(
            route('research-projects.update', $project),
            [
                'title' => $project->title,
                'status' => $project->status,
                'publications' => $newPublications
                    ->pluck('id')
                    ->toArray(),
            ]
        );

        $response->assertRedirect(
            route(
                'research-projects.show',
                $project->fresh()->slug
            )
        );

        $project->refresh();

        $this->assertEqualsCanonicalizing(
            $newPublications->pluck('id')->toArray(),
            $project->publications->pluck('id')->toArray()
        );

        $this->assertCount(
            2,
            $project->publications
        );
    }
}
