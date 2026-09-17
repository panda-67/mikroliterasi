<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchArea extends Model
{
    /** @use HasFactory<\Database\Factories\ResearchAreaFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
}
