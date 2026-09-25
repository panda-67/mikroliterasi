<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingMaterial extends Model
{
    /** @use HasFactory<\Database\Factories\TeachingMaterialFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'ppt_url',
        'created_by',
    ];

    /**
     * User who created the teaching material.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
