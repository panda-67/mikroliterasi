<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    use HasFactory;

    protected $fillable = [
        'research_project_id',
        'title',
        'description',
        'file',
        'document_type',
        'visibility',
    ];

    public function researchProject(): BelongsTo
    {
        return $this->belongsTo(ResearchProject::class);
    }
}
