<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
}
