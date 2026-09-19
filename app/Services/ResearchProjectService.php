<?php

namespace App\Services;

use App\Models\ResearchProject;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ResearchProjectService
{
    public function find(int $id): ?ResearchProject
    {
        return ResearchProject::find($id);
    }

    public function findBySlug(string $slug): ?ResearchProject
    {
        return ResearchProject::where('slug', $slug)->first();
    }

    public function getAll(int $length): LengthAwarePaginator
    {
        return ResearchProject::query()
            ->latest()
            ->paginate($length);
    }

    public function create(array $data): ResearchProject
    {
        return ResearchProject::create($data);
    }

    public function update(
        ResearchProject $project,
        array $data
    ): ResearchProject {
        $project->update($data);

        return $project->refresh();
    }

    public function delete(ResearchProject $project): bool
    {
        return $project->delete();
    }

    public function setFeaturedImage(
        ResearchProject $project,
        UploadedFile $file
    ): ResearchProject {
        $oldPath = $project->featured_image;

        $newPath = $file->store(
            'research-projects/featured',
            'public'
        );

        $project->update([
            'featured_image' => $newPath,
        ]);

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $project->refresh();
    }

    public function removeFeaturedImage(
        ResearchProject $project
    ): ResearchProject {
        $path = $project->featured_image;

        $project->update([
            'featured_image' => null,
        ]);

        if ($path) {
            Storage::disk('public')->delete($path);
        }

        return $project->refresh();
    }

    public function syncPeople(
        ResearchProject $project,
        array $people
    ): void {
        $project->people()->sync($people);
    }

    public function syncResearchAreas(
        ResearchProject $project,
        array $researchAreas
    ): void {
        $project->researchAreas()->sync($researchAreas);
    }

    public function syncPublications(
        ResearchProject $project,
        array $publications
    ): void {
        $project->publications()->sync($publications);
    }
}
