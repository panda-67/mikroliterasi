<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
