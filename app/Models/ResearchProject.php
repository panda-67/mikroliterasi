<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class ResearchProject extends Model
{
    /** @use HasFactory<\Database\Factories\ResearchProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'status',
        'start_date',
        'end_date',
        'location',
        'funding_source',
        'featured_image',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    protected function featuredImageUrl(): Attribute
    {
        return Attribute::get(
            fn() => $this->featured_image
                ? Storage::disk('public')->url(
                    $this->featured_image
                )
                : null
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(
            Person::class,
            'research_project_people'
        )->withPivot('role');
    }

    public function researchAreas(): BelongsToMany
    {
        return $this->belongsToMany(
            ResearchArea::class,
            'research_project_research_area'
        );
    }

    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(
            Publication::class,
            'research_project_publication'
        );
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
