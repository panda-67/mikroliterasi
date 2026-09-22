<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Publication extends Model
{
    /** @use HasFactory<\Database\Factories\PublicationFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'publication_type',
        'journal',
        'publisher',
        'year',
        'volume',
        'issue',
        'pages',
        'doi',
        'url',
        'abstract',
        'file',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(
            Person::class,
            'publication_people'
        )->withPivot('author_order');
    }

    public function researchProjects(): BelongsToMany
    {
        return $this->belongsToMany(
            ResearchProject::class,
            'research_project_publication'
        );
    }
}
