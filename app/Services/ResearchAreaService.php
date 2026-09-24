<?php

namespace App\Services;

use App\Models\ResearchArea;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
        return ResearchArea::create($data);
    }

    /**
     * Update a research area.
     */
    public function update(ResearchArea $researchArea, array $data): ResearchArea
    {
        $researchArea->update($data);

        return $researchArea->refresh();
    }

    /**
     * Delete a research area.
     */
    public function delete(ResearchArea $researchArea): void
    {
        $researchArea->delete();
    }
}
