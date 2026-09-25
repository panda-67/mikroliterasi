<?php

namespace App\Services;

use App\Models\Publication;
use Illuminate\Support\Str;

class PublicationService
{
    public function find(int $id): Publication
    {
        return Publication::findOrFail($id);
    }

    public function findBySlug(string $slug): Publication
    {
        return Publication::where('slug', $slug)->firstOrFail();
    }

    public function getAll(int $length = 12)
    {
        return Publication::query()
            ->with([
                'people',
                'researchProjects',
            ])
            ->latest('year')
            ->latest('id')
            ->paginate($length);
    }

    public function create(array $data): Publication
    {
        $data['slug'] = $this->generateUniqueSlug(
            $data['title']
        );

        return Publication::create($data);
    }

    public function update(
        Publication $publication,
        array $data
    ): Publication {
        $publication->update($data);

        return $publication->fresh();
    }

    public function delete(Publication $publication): void
    {
        $publication->delete();
    }

    public function syncPeople(
        Publication $publication,
        array $people
    ): void {
        $syncData = [];

        foreach ($people as $index => $person) {
            $syncData[$person['person_id']] = [
                'author_order' => $person['author_order'] ?? ($index + 1),
            ];
        }

        $publication->people()->sync($syncData);
    }

    public function syncResearchProjects(
        Publication $publication,
        array $researchProjects
    ): void {
        $publication->researchProjects()->sync(
            $researchProjects
        );
    }

    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Publication::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
