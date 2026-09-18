<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'featured_image',
        'published_at',
        'status',
        'author_id',
        'research_project_id',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }
}
