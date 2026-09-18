<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ResearchArea extends Model
{
    /** @use HasFactory<\Database\Factories\ResearchAreaFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function researchProjects(): BelongsToMany
    {
        return $this->belongsToMany(
            ResearchProject::class,
            'research_project_research_area'
        );
    }
}
