<?php

namespace App\Services;

use App\Models\TeachingMaterial;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class TeachingMaterialService
{
    public function getAll(int $perPage = 12): LengthAwarePaginator
    {
        return TeachingMaterial::query()
            ->with('creator')
            ->latest()
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): TeachingMaterial
    {
        return TeachingMaterial::query()
            ->with('creator')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function create(array $data): TeachingMaterial
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        return TeachingMaterial::create($data);
    }

    public function update(
        TeachingMaterial $teachingMaterial,
        array $data
    ): TeachingMaterial {
        $teachingMaterial->update($data);

        return $teachingMaterial->refresh();
    }

    public function delete(TeachingMaterial $teachingMaterial): void
    {
        $teachingMaterial->delete();
    }

    protected function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            TeachingMaterial::query()
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
