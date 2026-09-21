<?php

namespace App\Services;

use App\Models\Person;
use Illuminate\Support\Collection;

class PersonService
{
    public function getActive(): Collection
    {
        return Person::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }
}
