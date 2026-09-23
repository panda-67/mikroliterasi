<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\Publication;
use App\Models\ResearchProject;
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

    public function test_authenticated_user_can_create_publication_with_authors(): void
    {
        $user = User::factory()->create();

        $people = Person::factory()
            ->count(3)
            ->create();

        $this->actingAs($user)
            ->post(route('publications.store'), [
                'title' => 'Publication With Authors',
                'publication_type' => 'journal_article',
                'year' => 2026,
                'people' => [
                    [
                        'person_id' => $people[0]->id,
                        'author_order' => 1,
                    ],
                    [
                        'person_id' => $people[1]->id,
                        'author_order' => 2,
                    ],
                    [
                        'person_id' => $people[2]->id,
                        'author_order' => 3,
                    ],
                ],
            ])
            ->assertRedirect();

        $publication = Publication::where(
            'title',
            'Publication With Authors'
        )->firstOrFail();

        $this->assertDatabaseHas('publication_people', [
            'publication_id' => $publication->id,
            'person_id' => $people[0]->id,
            'author_order' => 1,
        ]);

        $this->assertDatabaseHas('publication_people', [
            'publication_id' => $publication->id,
            'person_id' => $people[1]->id,
            'author_order' => 2,
        ]);

        $this->assertDatabaseHas('publication_people', [
            'publication_id' => $publication->id,
            'person_id' => $people[2]->id,
            'author_order' => 3,
        ]);
    }

    public function test_authenticated_user_can_update_publication_authors(): void
    {
        $user = User::factory()->create();

        $people = Person::factory()
            ->count(3)
            ->create();

        $publication = Publication::factory()->create();

        $publication->people()->attach([
            $people[0]->id => [
                'author_order' => 1,
            ],
            $people[1]->id => [
                'author_order' => 2,
            ],
        ]);

        $this->actingAs($user)
            ->put(
                route('publications.update', $publication),
                [
                    'title' => $publication->title,
                    'publication_type' => $publication->publication_type,
                    'year' => $publication->year,
                    'people' => [
                        [
                            'person_id' => $people[2]->id,
                            'author_order' => 1,
                        ],
                    ],
                ]
            )
            ->assertRedirect();

        $this->assertDatabaseMissing('publication_people', [
            'publication_id' => $publication->id,
            'person_id' => $people[0]->id,
        ]);

        $this->assertDatabaseMissing('publication_people', [
            'publication_id' => $publication->id,
            'person_id' => $people[1]->id,
        ]);

        $this->assertDatabaseHas('publication_people', [
            'publication_id' => $publication->id,
            'person_id' => $people[2]->id,
            'author_order' => 1,
        ]);
    }

    public function test_publication_authors_cannot_be_duplicated(): void
    {
        $user = User::factory()->create();

        $person = Person::factory()->create();

        $response = $this->actingAs($user)
            ->post(
                route('publications.store'),
                [
                    'title' => 'Publication Duplicate Author',
                    'publication_type' => 'journal_article',
                    'year' => 2026,
                    'people' => [
                        [
                            'person_id' => $person->id,
                            'author_order' => 1,
                        ],
                        [
                            'person_id' => $person->id,
                            'author_order' => 2,
                        ],
                    ],
                ]
            );

        $response
            ->assertSessionHasErrors('people.1.person_id');

        $this->assertDatabaseMissing('publications', [
            'title' => 'Publication Duplicate Author',
        ]);
    }

    public function test_authenticated_user_can_create_publication_with_research_projects(): void
    {
        $user = User::factory()->create();

        $projects = ResearchProject::factory()
            ->count(3)
            ->create();

        $this->actingAs($user)
            ->post(route('publications.store'), [
                'title' => 'Publication With Research Projects',
                'publication_type' => 'journal_article',
                'year' => 2026,
                'research_projects' => $projects
                    ->pluck('id')
                    ->toArray(),
            ])
            ->assertRedirect();

        $publication = Publication::where(
            'title',
            'Publication With Research Projects'
        )->firstOrFail();

        foreach ($projects as $project) {
            $this->assertDatabaseHas(
                'research_project_publication',
                [
                    'publication_id' => $publication->id,
                    'research_project_id' => $project->id,
                ]
            );
        }
    }

    public function test_authenticated_user_can_update_publication_research_projects(): void
    {
        $user = User::factory()->create();

        $projects = ResearchProject::factory()
            ->count(3)
            ->create();

        $publication = Publication::factory()->create();

        $publication->researchProjects()->attach([
            $projects[0]->id,
            $projects[1]->id,
        ]);

        $this->actingAs($user)
            ->put(
                route('publications.update', $publication),
                [
                    'title' => $publication->title,
                    'publication_type' => $publication->publication_type,
                    'year' => $publication->year,
                    'research_projects' => [
                        $projects[2]->id,
                    ],
                ]
            )
            ->assertRedirect();

        $this->assertDatabaseMissing(
            'research_project_publication',
            [
                'publication_id' => $publication->id,
                'research_project_id' => $projects[0]->id,
            ]
        );

        $this->assertDatabaseMissing(
            'research_project_publication',
            [
                'publication_id' => $publication->id,
                'research_project_id' => $projects[1]->id,
            ]
        );

        $this->assertDatabaseHas(
            'research_project_publication',
            [
                'publication_id' => $publication->id,
                'research_project_id' => $projects[2]->id,
            ]
        );
    }

    public function test_publication_research_projects_cannot_be_duplicated(): void
    {
        $user = User::factory()->create();

        $project = ResearchProject::factory()->create();

        $response = $this->actingAs($user)
            ->post(
                route('publications.store'),
                [
                    'title' => 'Publication Duplicate Project',
                    'publication_type' => 'journal_article',
                    'year' => 2026,
                    'research_projects' => [
                        $project->id,
                        $project->id,
                    ],
                ]
            );

        $response
            ->assertSessionHasErrors(
                'research_projects.1'
            );

        $this->assertDatabaseMissing(
            'publications',
            [
                'title' => 'Publication Duplicate Project',
            ]
        );
    }
}
