<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $post = $this->route('post');

        if (! $user) {
            return false;
        }

        return $post instanceof Post
            ? $user->can('update', $post)
            : $user->can('create', Post::class);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],

            'category' => [
                'required',
                Rule::in(['research_update', 'publication', 'field_activity', 'institutional', 'announcement']),
            ],

            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'published_at' => ['nullable', 'date'],

            'status' => [
                'required',
                Rule::in(['draft', 'published', 'archived']),
            ],

            'research_project_id' => ['nullable', 'integer', 'exists:research_projects,id'],
        ];
    }
}
