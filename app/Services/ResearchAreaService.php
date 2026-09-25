<?php

namespace App\Services;

use App\Models\ResearchArea;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ResearchAreaService
{
    /**
     * Get paginated research areas.
     */
    public function getAll(int $perPage = 12): LengthAwarePaginator
    {
        return ResearchArea::withCount('researchProjects')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Create a research area.
     */
    public function create(array $data): ResearchArea
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);

        return ResearchArea::create($data);
    }

    /**
     * Update a research area.
     */
    public function update(ResearchArea $researchArea, array $data): ResearchArea
    {
        $researchArea->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return $researchArea->refresh();
    }

    /**
     * Delete a research area.
     */
    public function delete(ResearchArea $researchArea): void
    {
        $researchArea->delete();
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (ResearchArea::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
