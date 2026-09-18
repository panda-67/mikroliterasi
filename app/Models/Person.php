<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    /** @use HasFactory<\Database\Factories\PersonFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'position',
        'short_bio',
        'bio',
        'email',
        'website',
        'education',
        'research_interests',
        'status',
    ];

    public function researchProjects(): BelongsToMany
    {
        return $this->belongsToMany(
            ResearchProject::class,
            'research_project_people'
        )->withPivot('role');
    }

    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(
            Publication::class,
            'publication_people'
        )->withPivot('author_order');
    }
}
