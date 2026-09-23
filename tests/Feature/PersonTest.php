<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonTest extends TestCase
{
    use RefreshDatabase;

    public function test_person_requires_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/people', [
                'status' => 'active',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_person_rejects_invalid_academic_profile_urls(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/people', [
                'name' => 'Test Researcher',
                'status' => 'active',
                'scopus' => 'not-a-url',
                'google_scholar' => 'not-a-url',
                'orcid' => 'not-a-url',
                'sinta' => 'not-a-url',
            ]);

        $response->assertSessionHasErrors([
            'scopus',
            'google_scholar',
            'orcid',
            'sinta',
        ]);
    }

    public function test_person_rejects_invalid_status(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/people', [
                'name' => 'Test Researcher',
                'status' => 'invalid',
            ]);

        $response->assertSessionHasErrors('status');
    }

    public function test_authenticated_user_can_create_person(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('people.store'), [
                'name' => 'Dr. Test Researcher',
                'position' => 'Researcher',
                'email' => 'test@example.com',
                'website' => 'https://example.com',
                'scopus' => 'https://example.com/scopus',
                'google_scholar' => 'https://example.com/google-scholar',
                'orcid' => 'https://orcid.org/0000-0000-0000-0000',
                'sinta' => 'https://example.com/sinta',
                'education' => 'Biology',
                'research_interests' => 'Conservation',
                'status' => 'active',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('people', [
            'name' => 'Dr. Test Researcher',
            'slug' => 'dr-test-researcher',
            'orcid' => 'https://orcid.org/0000-0000-0000-0000',
        ]);
    }

    public function test_authenticated_user_can_update_person(): void
    {
        $user = User::factory()->create();

        $person = Person::factory()->create([
            'name' => 'Old Name',
            'position' => 'Researcher',
        ]);

        $this->actingAs($user)
            ->put(route('people.update', $person), [
                'name' => 'New Name',
                'position' => 'Senior Researcher',
                'status' => 'active',
                'orcid' => 'https://orcid.org/0000-0000-0000-0001',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('people', [
            'id' => $person->id,
            'name' => 'New Name',
            'position' => 'Senior Researcher',
            'orcid' => 'https://orcid.org/0000-0000-0000-0001',
        ]);
    }

    public function test_person_slug_does_not_change_when_name_is_updated(): void
    {
        $user = User::factory()->create();

        $person = Person::factory()->create([
            'name' => 'Original Name',
            'slug' => 'original-name',
        ]);

        $this->actingAs($user)
            ->put(route('people.update', $person), [
                'name' => 'Changed Name',
                'status' => 'active',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('people', [
            'id' => $person->id,
            'name' => 'Changed Name',
            'slug' => 'original-name',
        ]);
    }

    public function test_authenticated_user_can_delete_person(): void
    {
        $user = User::factory()->create();

        $person = Person::factory()->create();

        $this->actingAs($user)
            ->delete(route('people.destroy', $person))
            ->assertRedirect(route('people.index'));

        $this->assertDatabaseMissing('people', [
            'id' => $person->id,
        ]);
    }

    public function test_guest_cannot_create_person(): void
    {
        $this->post(route('people.store'), [
            'name' => 'Test Researcher',
            'status' => 'active',
        ])
            ->assertRedirect(route('login'));
    }
}
