<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;
use Mockery;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Mock Google user data.
     */
    private function makeGoogleUser(
        string $id = 'google-123',
        string $email = 'student@gmail.com',
        string $name = 'Student Test',
        bool $verified = true
    ): GoogleUser {
        return GoogleUser::fake([
            'id' => $id,
            'email' => $email,
            'name' => $name,
            'email_verified' => $verified,
        ]);
    }

    /**
     * Mock Socialite Google provider.
     */
    private function mockGoogleProvider(GoogleUser $googleUser): void
    {
        $provider = Mockery::mock(Provider::class);

        $provider->shouldReceive('user')
            ->once()
            ->andReturn($googleUser);

        Socialite::shouldReceive('driver')
            ->once()
            ->with('google')
            ->andReturn($provider);
    }

    /**
     * Test redirect to Google OAuth.
     */
    public function test_user_can_redirect_to_google(): void
    {
        $provider = Mockery::mock(Provider::class);

        $provider->shouldReceive('redirect')
            ->once()
            ->andReturn(
                new RedirectResponse('https://accounts.google.com/')
            );

        Socialite::shouldReceive('driver')
            ->once()
            ->with('google')
            ->andReturn($provider);

        $response = $this->get(route('google.redirect'));

        $response->assertRedirect('https://accounts.google.com/');
    }

    /**
     * Test automatic student registration.
     */
    public function test_google_can_register_new_student(): void
    {
        $this->mockGoogleProvider(
            $this->makeGoogleUser()
        );

        $response = $this->get(route('google.callback'));

        $response->assertRedirect('/dashboard');

        $user = User::where('email', 'student@gmail.com')->first();

        $this->assertNotNull($user);
        $this->assertEquals('student', $user->role);
        $this->assertEquals('google-123', $user->google_id);
        $this->assertNotNull($user->email_verified_at);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test linking an existing student account.
     */
    public function test_google_can_link_existing_student_account(): void
    {
        $student = User::factory()->create([
            'name' => 'Existing Student',
            'email' => 'student@gmail.com',
            'google_id' => null,
            'role' => 'student',
            'email_verified_at' => null,
        ]);

        $this->mockGoogleProvider(
            $this->makeGoogleUser()
        );

        $response = $this->get(route('google.callback'));

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'email' => 'student@gmail.com',
            'google_id' => 'google-123',
            'role' => 'student',
        ]);

        $student->refresh();

        $this->assertNotNull($student->email_verified_at);
        $this->assertAuthenticatedAs($student);
    }

    /**
     * Test login using an already linked Google account.
     */
    public function test_linked_student_can_login_with_google(): void
    {
        $student = User::factory()->create([
            'email' => 'student@gmail.com',
            'google_id' => 'google-123',
            'role' => 'student',
        ]);

        $this->mockGoogleProvider(
            $this->makeGoogleUser()
        );

        $response = $this->get(route('google.callback'));

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($student);
    }

    /**
     * Test researcher cannot login with Google.
     */
    public function test_researcher_cannot_login_with_google(): void
    {
        $researcher = User::factory()->create([
            'email' => 'student@gmail.com',
            'google_id' => null,
            'role' => 'researcher',
        ]);

        $this->mockGoogleProvider(
            $this->makeGoogleUser()
        );

        $response = $this->get(route('google.callback'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['google']);

        $this->assertGuest();

        $this->assertDatabaseHas('users', [
            'id' => $researcher->id,
            'role' => 'researcher',
            'google_id' => null,
        ]);
    }

    /**
     * Test admin cannot login with Google.
     */
    public function test_admin_cannot_login_with_google(): void
    {
        $admin = User::factory()->create([
            'email' => 'student@gmail.com',
            'google_id' => null,
            'role' => 'admin',
        ]);

        $this->mockGoogleProvider(
            $this->makeGoogleUser()
        );

        $response = $this->get(route('google.callback'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['google']);

        $this->assertGuest();

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'role' => 'admin',
            'google_id' => null,
        ]);
    }

    /**
     * Test Google ID cannot be used by another account.
     */
    public function test_google_id_cannot_be_used_by_another_account(): void
    {
        User::factory()->create([
            'email' => 'another@gmail.com',
            'google_id' => 'google-123',
            'role' => 'student',
        ]);

        $this->mockGoogleProvider(
            $this->makeGoogleUser(
                id: 'google-123',
                email: 'student@gmail.com'
            )
        );

        $response = $this->get(route('google.callback'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['google']);

        $this->assertGuest();

        $this->assertDatabaseMissing('users', [
            'email' => 'student@gmail.com',
        ]);
    }

    /**
     * Test student account cannot be linked to a different Google ID.
     */
    public function test_student_cannot_replace_existing_google_id(): void
    {
        $student = User::factory()->create([
            'email' => 'student@gmail.com',
            'google_id' => 'google-old',
            'role' => 'student',
        ]);

        $this->mockGoogleProvider(
            $this->makeGoogleUser(
                id: 'google-new',
                email: 'student@gmail.com'
            )
        );

        $response = $this->get(route('google.callback'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['google']);

        $this->assertGuest();

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'google_id' => 'google-old',
        ]);
    }

    /**
     * Test Google account with unverified email is rejected.
     */
    public function test_unverified_google_email_is_rejected(): void
    {
        $this->mockGoogleProvider(
            $this->makeGoogleUser(
                verified: false
            )
        );

        $response = $this->get(route('google.callback'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['google']);

        $this->assertGuest();

        $this->assertDatabaseMissing('users', [
            'email' => 'student@gmail.com',
        ]);
    }

    /**
     * Test Fortify email/password login remains functional.
     */
    public function test_user_can_still_login_using_fortify(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }
}
