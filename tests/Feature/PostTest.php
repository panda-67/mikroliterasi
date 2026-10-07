<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\ResearchProject;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Public access
    |--------------------------------------------------------------------------
    */

    public function test_guest_can_view_published_posts(): void
    {
        Post::factory()->count(2)->published()->create();
        Post::factory()->draft()->create();
        Post::factory()->archived()->create();

        $response = $this->get(route('posts.index'));

        $response->assertOk();
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts');
    }

    public function test_guest_can_view_published_post(): void
    {
        $post = Post::factory()->published()->create();

        $response = $this->get(
            route('posts.show', $post)
        );

        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', function ($viewPost) use ($post) {
            return $viewPost->is($post);
        });
    }

    public function test_guest_cannot_view_draft_post(): void
    {
        $post = Post::factory()->draft()->create();

        $response = $this->get(
            route('posts.show', $post)
        );

        $response->assertNotFound();
    }

    public function test_guest_cannot_view_archived_post(): void
    {
        $post = Post::factory()->archived()->create();

        $response = $this->get(
            route('posts.show', $post)
        );

        $response->assertNotFound();
    }

    /*
    |--------------------------------------------------------------------------
    | Policy
    |--------------------------------------------------------------------------
    */

    public function test_admin_has_full_post_permissions(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $post = Post::factory()->create();

        $this->assertTrue($user->can('viewAny', Post::class));
        $this->assertTrue($user->can('view', $post));
        $this->assertTrue($user->can('create', Post::class));
        $this->assertTrue($user->can('update', $post));
        $this->assertTrue($user->can('delete', $post));
    }

    public function test_editor_can_create_and_update_but_not_delete(): void
    {
        $user = User::factory()->create([
            'role' => 'editor',
        ]);

        $post = Post::factory()->create();

        $this->assertTrue($user->can('viewAny', Post::class));
        $this->assertTrue($user->can('view', $post));
        $this->assertTrue($user->can('create', Post::class));
        $this->assertTrue($user->can('update', $post));
        $this->assertFalse($user->can('delete', $post));
    }

    public function test_researcher_cannot_manage_posts(): void
    {
        $user = User::factory()->create([
            'role' => 'researcher',
        ]);

        $post = Post::factory()->create();

        $this->assertFalse($user->can('viewAny', Post::class));
        $this->assertFalse($user->can('view', $post));
        $this->assertFalse($user->can('create', Post::class));
        $this->assertFalse($user->can('update', $post));
        $this->assertFalse($user->can('delete', $post));
    }

    public function test_student_cannot_manage_posts(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $post = Post::factory()->create();

        $this->assertFalse($user->can('viewAny', Post::class));
        $this->assertFalse($user->can('view', $post));
        $this->assertFalse($user->can('create', Post::class));
        $this->assertFalse($user->can('update', $post));
        $this->assertFalse($user->can('delete', $post));
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function test_admin_can_create_post(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Elephant Corridor Research Update',
                'excerpt' => 'Research update.',
                'content' => 'Research content.',
                'category' => 'research_update',
                'featured_image' => null,
                'published_at' => null,
                'status' => 'draft',
                'research_project_id' => null,
            ]);

        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'Elephant Corridor Research Update',
            'slug' => 'elephant-corridor-research-update',
            'author_id' => $user->id,
            'status' => 'draft',
        ]);
    }

    public function test_editor_can_create_post(): void
    {
        $user = User::factory()->create([
            'role' => 'editor',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Field Activity Update',
                'excerpt' => 'Field activity.',
                'content' => 'Field activity content.',
                'category' => 'field_activity',
                'status' => 'draft',
            ]);

        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'Field Activity Update',
            'author_id' => $user->id,
        ]);
    }

    public function test_researcher_cannot_create_post(): void
    {
        $user = User::factory()->create([
            'role' => 'researcher',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Unauthorized Post',
                'content' => 'Content.',
                'category' => 'announcement',
                'status' => 'draft',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('posts', [
            'title' => 'Unauthorized Post',
        ]);
    }

    public function test_guest_cannot_create_post(): void
    {
        $response = $this->post(route('posts.store'), [
            'title' => 'Unauthorized Post',
            'content' => 'Content.',
            'category' => 'announcement',
            'status' => 'draft',
        ]);

        $response->assertRedirect();

        $this->assertGuest();

        $this->assertDatabaseMissing('posts', [
            'title' => 'Unauthorized Post',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Slug
    |--------------------------------------------------------------------------
    */

    public function test_slug_is_generated_from_title(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'My Research Activity',
                'content' => 'Content.',
                'category' => 'research_update',
                'status' => 'draft',
            ]);

        $this->assertDatabaseHas('posts', [
            'slug' => 'my-research-activity',
        ]);
    }

    public function test_duplicate_titles_generate_unique_slugs(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $data = [
            'title' => 'Research Update',
            'content' => 'Content.',
            'category' => 'research_update',
            'status' => 'draft',
        ];

        $this
            ->actingAs($user)
            ->post(route('posts.store'), $data);

        $this
            ->actingAs($user)
            ->post(route('posts.store'), $data);

        $this->assertDatabaseHas('posts', [
            'slug' => 'research-update',
        ]);

        $this->assertDatabaseHas('posts', [
            'slug' => 'research-update-1',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Published state
    |--------------------------------------------------------------------------
    */

    public function test_published_post_gets_published_at_automatically(): void
    {
        Carbon::setTestNow('2026-10-07 20:00:00');

        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Published Research',
                'content' => 'Content.',
                'category' => 'publication',
                'status' => 'published',
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Published Research',
            'status' => 'published',
            'published_at' => '2026-10-07 20:00:00',
        ]);

        Carbon::setTestNow();
    }

    public function test_explicit_published_at_is_preserved(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $publishedAt = '2026-01-15 10:30:00';

        $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Historical Publication',
                'content' => 'Content.',
                'category' => 'publication',
                'status' => 'published',
                'published_at' => $publishedAt,
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Historical Publication',
            'published_at' => $publishedAt,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function test_admin_can_update_post(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $post = Post::factory()->draft()->create([
            'author_id' => $user->id,
        ]);

        $originalSlug = $post->slug;
        $originalAuthor = $post->author_id;

        $response = $this
            ->actingAs($user)
            ->put(route('posts.update', $post), [
                'title' => 'Updated Post Title',
                'content' => 'Updated content.',
                'category' => 'announcement',
                'status' => 'published',
            ]);

        $response->assertRedirect(route('posts.index'));

        $post->refresh();

        $this->assertSame(
            $originalSlug,
            $post->slug
        );

        $this->assertSame(
            $originalAuthor,
            $post->author_id
        );

        $this->assertSame(
            'Updated Post Title',
            $post->title
        );

        $this->assertSame(
            'published',
            $post->status
        );

        $this->assertNotNull(
            $post->published_at
        );
    }

    public function test_editor_can_update_post(): void
    {
        $user = User::factory()->create([
            'role' => 'editor',
        ]);

        $post = Post::factory()->draft()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('posts.update', $post), [
                'title' => 'Editor Updated Post',
                'content' => 'Updated content.',
                'category' => 'research_update',
                'status' => 'draft',
            ]);

        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Editor Updated Post',
        ]);
    }

    public function test_researcher_cannot_update_post(): void
    {
        $user = User::factory()->create([
            'role' => 'researcher',
        ]);

        $post = Post::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('posts.update', $post), [
                'title' => 'Unauthorized Update',
                'content' => 'Updated.',
                'category' => 'announcement',
                'status' => 'draft',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('posts', [
            'title' => 'Unauthorized Update',
        ]);
    }

    public function test_slug_cannot_be_changed_during_update(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $post = Post::factory()->draft()->create();

        $originalSlug = $post->slug;

        $this
            ->actingAs($user)
            ->put(route('posts.update', $post), [
                'title' => 'Completely Different Title',
                'slug' => 'malicious-new-slug',
                'content' => 'Updated content.',
                'category' => 'announcement',
                'status' => 'draft',
            ]);

        $post->refresh();

        $this->assertSame(
            $originalSlug,
            $post->slug
        );

        $this->assertSame(
            'Completely Different Title',
            $post->title
        );
    }

    public function test_author_cannot_be_changed_during_update(): void
    {
        $author = User::factory()->create([
            'role' => 'admin',
        ]);

        $attacker = User::factory()->create([
            'role' => 'admin',
        ]);

        $post = Post::factory()->draft()->create([
            'author_id' => $author->id,
        ]);

        $this
            ->actingAs($attacker)
            ->put(route('posts.update', $post), [
                'title' => $post->title,
                'content' => $post->content,
                'category' => $post->category,
                'status' => 'draft',
                'author_id' => $attacker->id,
            ]);

        $post->refresh();

        $this->assertSame(
            $author->id,
            $post->author_id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function test_admin_can_delete_post(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $post = Post::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_editor_cannot_delete_post(): void
    {
        $user = User::factory()->create([
            'role' => 'editor',
        ]);

        $post = Post::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('posts.destroy', $post));

        $response->assertForbidden();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_researcher_cannot_delete_post(): void
    {
        $user = User::factory()->create([
            'role' => 'researcher',
        ]);

        $post = Post::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('posts.destroy', $post));

        $response->assertForbidden();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    public function test_title_is_required(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'content' => 'Content.',
                'category' => 'announcement',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_content_is_required(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Test Post',
                'category' => 'announcement',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_category_must_be_valid(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Test Post',
                'content' => 'Content.',
                'category' => 'invalid_category',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors('category');
    }

    public function test_status_must_be_valid(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'Test Post',
                'content' => 'Content.',
                'category' => 'announcement',
                'status' => 'invalid_status',
            ]);

        $response->assertSessionHasErrors('status');
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function test_post_relationships_are_available(): void
    {
        $author = User::factory()->create([
            'role' => 'admin',
        ]);

        $researchProject = ResearchProject::factory()->create();

        $post = Post::factory()->create([
            'author_id' => $author->id,
            'research_project_id' => $researchProject->id,
        ]);

        $post->load([
            'author',
            'researchProject',
        ]);

        $this->assertTrue(
            $post->author->is($author)
        );

        $this->assertTrue(
            $post->researchProject->is($researchProject)
        );
    }

    public function test_post_can_be_created_with_featured_image(): void
    {
        Storage::fake('public');

        $author = User::factory()->create([
            'role' => 'admin',
        ]);

        $file = UploadedFile::fake()->image('featured.jpg');

        $post = app(PostService::class)->create(
            [
                'title' => 'Post With Featured Image',
                'excerpt' => 'Test excerpt',
                'content' => 'Test content',
                'category' => 'research_update',
                'featured_image' => $file,
                'published_at' => null,
                'status' => 'draft',
                'research_project_id' => null,
            ],
            $author
        );

        $this->assertNotNull(
            $post->featured_image
        );

        Storage::disk('public')->assertExists(
            $post->featured_image
        );
    }

    public function test_post_featured_image_can_be_replaced(): void
    {
        Storage::fake('public');

        $author = User::factory()->create([
            'role' => 'admin',
        ]);

        $post = Post::factory()->create([
            'author_id' => $author->id,
        ]);

        $service = app(PostService::class);

        $oldFile = UploadedFile::fake()->image('old.jpg');

        $service->setFeaturedImage(
            $post,
            $oldFile
        );

        $post->refresh();

        $oldPath = $post->featured_image;

        Storage::disk('public')->assertExists($oldPath);

        $newFile = UploadedFile::fake()->image('new.jpg');

        $updatedPost = $service->update(
            $post,
            [
                'title' => $post->title,
                'excerpt' => $post->excerpt,
                'content' => $post->content,
                'category' => $post->category,
                'featured_image' => $newFile,
                'published_at' => $post->published_at,
                'status' => $post->status,
                'research_project_id' => $post->research_project_id,
            ]
        );

        $this->assertNotEquals(
            $oldPath,
            $updatedPost->featured_image
        );

        Storage::disk('public')->assertMissing(
            $oldPath
        );

        Storage::disk('public')->assertExists(
            $updatedPost->featured_image
        );
    }

    public function test_post_featured_image_can_be_removed(): void
    {
        Storage::fake('public');

        $author = User::factory()->create([
            'role' => 'admin',
        ]);

        $post = Post::factory()->create([
            'author_id' => $author->id,
        ]);

        $service = app(PostService::class);

        $file = UploadedFile::fake()->image('featured.jpg');

        $service->setFeaturedImage(
            $post,
            $file
        );

        $post->refresh();

        $path = $post->featured_image;

        Storage::disk('public')->assertExists($path);

        $service->removeFeaturedImage($post);

        $post->refresh();

        $this->assertNull(
            $post->featured_image
        );

        Storage::disk('public')->assertMissing($path);
    }

    public function test_post_featured_image_url_is_available(): void
    {
        Storage::fake('public');

        $author = User::factory()->create([
            'role' => 'admin',
        ]);

        $post = Post::factory()->create([
            'author_id' => $author->id,
            'featured_image' => 'posts/featured/image.jpg',
        ]);

        Storage::disk('public')->put(
            'posts/featured/image.jpg',
            'image'
        );

        $post->refresh();

        $this->assertNotNull(
            $post->featured_image_url
        );

        $this->assertStringContainsString(
            'storage/posts/featured/image.jpg',
            $post->featured_image_url
        );
    }
}
