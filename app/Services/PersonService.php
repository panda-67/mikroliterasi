<?php

namespace App\Services;

use App\Models\Person;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PersonService
{
    public function find(int $id): Person
    {
        return Person::findOrFail($id);
    }

    public function findBySlug(string $slug): Person
    {
        return Person::where('slug', $slug)->firstOrFail();
    }

    public function getActive(): Collection
    {
        return Person::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }

    public function getAll(int $length = 12)
    {
        return Person::query()
            ->orderBy('name')
            ->paginate($length);
    }

    public function create(array $data): Person
    {
        $data['slug'] = $this->generateUniqueSlug(
            $data['name']
        );

        return Person::create($data);
    }

    public function update(
        Person $person,
        array $data
    ): Person {
        $person->update($data);

        return $person->fresh();
    }

    public function delete(Person $person): void
    {
        $person->delete();
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Person::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
