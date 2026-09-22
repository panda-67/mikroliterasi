<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_publication(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('publications.store'),
            [
                'title' => 'Sumatran Elephant Habitat Assessment',
                'publication_type' => 'journal_article',
                'journal' => 'Journal of Conservation Biology',
                'publisher' => 'Mikroliterasi Research',
                'year' => 2026,
                'volume' => '12',
                'issue' => '2',
                'pages' => '101-115',
                'doi' => '10.1234/example.2026',
                'url' => 'https://example.com/publication',
                'abstract' => 'This is a test publication abstract.',
            ]
        );

        $publication = Publication::first();

        $response->assertRedirect(
            route('publications.show', $publication->slug)
        );

        $this->assertDatabaseHas('publications', [
            'id' => $publication->id,
            'title' => 'Sumatran Elephant Habitat Assessment',
            'publication_type' => 'journal_article',
            'year' => 2026,
        ]);
    }

    public function test_create_requires_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('publications.store'),
            [
                'publication_type' => 'journal_article',
            ]
        );

        $response->assertSessionHasErrors('title');

        $this->assertDatabaseCount(
            'publications',
            0
        );
    }

    public function test_create_rejects_invalid_publication_type(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('publications.store'),
            [
                'title' => 'Test Publication',
                'publication_type' => 'invalid_type',
            ]
        );

        $response->assertSessionHasErrors(
            'publication_type'
        );

        $this->assertDatabaseCount(
            'publications',
            0
        );
    }

    public function test_authenticated_user_can_update_publication(): void
    {
        $user = User::factory()->create();

        $publication = Publication::factory()->create([
            'title' => 'Original Publication',
            'publication_type' => 'journal_article',
        ]);

        $response = $this->actingAs($user)->put(
            route('publications.update', $publication),
            [
                'title' => 'Updated Publication',
                'publication_type' => 'technical_report',
                'year' => 2026,
            ]
        );

        $response->assertRedirect(
            route(
                'publications.show',
                $publication->fresh()->slug
            )
        );

        $this->assertDatabaseHas('publications', [
            'id' => $publication->id,
            'title' => 'Updated Publication',
            'publication_type' => 'technical_report',
            'year' => 2026,
        ]);
    }

    public function test_update_validation_failure_does_not_change_publication(): void
    {
        $user = User::factory()->create();

        $publication = Publication::factory()->create([
            'title' => 'Original Publication',
            'publication_type' => 'journal_article',
            'year' => 2025,
        ]);

        $response = $this->actingAs($user)->put(
            route('publications.update', $publication),
            [
                'title' => '',
                'publication_type' => 'journal_article',
            ]
        );

        $response->assertSessionHasErrors('title');

        $this->assertDatabaseHas('publications', [
            'id' => $publication->id,
            'title' => 'Original Publication',
            'year' => 2025,
        ]);
    }

    public function test_authenticated_user_can_delete_publication(): void
    {
        $user = User::factory()->create();

        $publication = Publication::factory()->create();

        $response = $this->actingAs($user)->delete(
            route('publications.destroy', $publication)
        );

        $response->assertRedirect(
            route('publications.index')
        );

        $this->assertDatabaseMissing('publications', [
            'id' => $publication->id,
        ]);
    }

    public function test_guest_cannot_create_publication(): void
    {
        $response = $this->post(
            route('publications.store'),
            [
                'title' => 'Guest Publication',
                'publication_type' => 'journal_article',
            ]
        );

        $response->assertRedirect(
            route('login')
        );

        $this->assertDatabaseCount(
            'publications',
            0
        );
    }

    public function test_publication_slug_does_not_change_when_title_is_updated(): void
    {
        $user = User::factory()->create();

        $publication = Publication::factory()->create([
            'title' => 'Original Publication',
            'slug' => 'original-publication',
            'publication_type' => 'journal_article',
        ]);

        $response = $this->actingAs($user)->put(
            route('publications.update', $publication),
            [
                'title' => 'Updated Publication',
                'publication_type' => 'journal_article',
            ]
        );

        $response->assertRedirect(
            route(
                'publications.show',
                'original-publication'
            )
        );

        $publication->refresh();

        $this->assertSame(
            'original-publication',
            $publication->slug
        );
    }
}
