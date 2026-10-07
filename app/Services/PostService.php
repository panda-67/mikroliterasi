<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function find(int $id): Post
    {
        return Post::findOrFail($id);
    }

    public function findBySlug(string $slug): Post
    {
        return Post::where('slug', $slug)
            ->with([
                'author',
                'researchProject',
                'media',
            ])
            ->firstOrFail();
    }

    public function findPublishedBySlug(string $slug): Post
    {
        return Post::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'author',
                'researchProject',
                'media',
            ])
            ->firstOrFail();
    }

    public function getAll(int $length = 12)
    {
        return Post::query()
            ->with([
                'author',
                'researchProject',
            ])
            ->latest('updated_at')
            ->latest('id')
            ->paginate($length);
    }

    public function getPublished(int $length = 12)
    {
        return Post::query()
            ->where('status', 'published')
            ->with([
                'author',
                'researchProject',
            ])
            ->latest('published_at')
            ->latest('id')
            ->paginate($length);
    }

    public function create(
        array $data,
        User $author
    ): Post {
        $file = $data['featured_image'] ?? null;

        unset($data['featured_image']);

        $data['slug'] = $this->generateUniqueSlug(
            $data['title']
        );

        $data['author_id'] = $author->id;

        if (
            $data['status'] === 'published'
            && empty($data['published_at'])
        ) {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        if ($file) {
            $this->setFeaturedImage($post, $file);
        }

        return $post->refresh();
    }

    public function update(
        Post $post,
        array $data
    ): Post {
        $file = $data['featured_image'] ?? null;

        unset($data['featured_image']);
        unset($data['slug']);
        unset($data['author_id']);

        if (
            $data['status'] === 'published'
            && ! $post->published_at
        ) {
            $data['published_at'] = now();
        }

        $post->update($data);

        if ($file) {
            $this->setFeaturedImage($post, $file);
        }

        return $post->refresh();
    }

    public function delete(Post $post): void
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete(
                $post->featured_image
            );
        }

        $post->delete();
    }

    public function setFeaturedImage(
        Post $post,
        UploadedFile $file
    ): Post {
        $oldPath = $post->featured_image;

        $newPath = $file->store(
            'posts/featured',
            'public'
        );

        $post->update([
            'featured_image' => $newPath,
        ]);

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $post->refresh();
    }

    public function removeFeaturedImage(
        Post $post
    ): Post {
        $path = $post->featured_image;

        $post->update([
            'featured_image' => null,
        ]);

        if ($path) {
            Storage::disk('public')->delete($path);
        }

        return $post->refresh();
    }

    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
