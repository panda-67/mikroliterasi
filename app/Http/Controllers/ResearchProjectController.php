<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchProjectRequest;
use App\Models\Publication;
use App\Models\ResearchArea;
use App\Models\ResearchProject;
use App\Services\PersonService;
use App\Services\ResearchProjectService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ResearchProjectController extends Controller implements HasMiddleware
{
    public function __construct(
        protected ResearchProjectService $projectService,
        protected PersonService $personService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: [
                'create',
                'store',
                'edit',
                'update',
                'destroy',
                'removeFeaturedImage',
            ]),
        ];
    }

    public function index()
    {
        $projects = $this->projectService->getAll(12);

        return view('research-projects.index', compact('projects'));
    }

    public function show(ResearchProject $researchProject)
    {
        $researchProject->load([
            'people',
            'researchAreas',
            'publications',
        ]);

        return view('research-projects.show', compact('researchProject'));
    }

    public function create()
    {
        $people = $this->personService->getActive();

        $researchAreas = ResearchArea::query()
            ->orderBy('name')
            ->get();

        $publications = Publication::orderByDesc('year')
            ->orderBy('title')
            ->get();

        return view('research-projects.create', compact(
            'people',
            'researchAreas',
            'publications'
        ));
    }

    public function store(ResearchProjectRequest $request)
    {
        $data = $request->validated();

        $people = $data['people'] ?? [];
        $researchAreas = $data['research_areas'] ?? [];
        $publications = $data['publications'] ?? [];

        unset(
            $data['people'],
            $data['research_areas'],
            $data['publications']
        );

        $project = $this->projectService->create($data);

        $this->projectService->syncPeople($project, $people);

        $this->projectService->syncResearchAreas($project, $researchAreas);

        $this->projectService->syncPublications($project, $publications);

        return redirect()
            ->route('research-projects.show', $project->slug)
            ->with('success', 'Research project berhasil dibuat.');
    }

    public function edit(ResearchProject $researchProject)
    {
        $researchProject->load('people');
        $people = $this->personService->getActive();

        $researchAreas = ResearchArea::query()
            ->orderBy('name')
            ->get();

        $publications = Publication::orderByDesc('year')
            ->orderBy('title')
            ->get();

        return view('research-projects.edit', compact(
            'researchProject',
            'people',
            'researchAreas',
            'publications'
        ));
    }

    public function update(ResearchProjectRequest $request, ResearchProject $researchProject)
    {
        $data = $request->validated();

        $people = $data['people'] ?? [];
        $researchAreas = $data['research_areas'] ?? [];
        $publications = $data['publications'] ?? [];

        unset(
            $data['people'],
            $data['research_areas'],
            $data['publications']
        );

        $this->projectService->update($researchProject, $data);

        $this->projectService->syncPeople($researchProject, $people);

        $this->projectService->syncResearchAreas($researchProject, $researchAreas);

        $this->projectService->syncPublications($researchProject, $publications);

        $project = $researchProject->fresh([
            'people',
            'researchAreas',
            'publications'
        ]);

        return redirect()
            ->route('research-projects.show', $project->slug)
            ->with('success', 'Research project berhasil diperbarui.');
    }

    public function destroy(ResearchProject $researchProject)
    {
        $this->projectService->delete($researchProject);

        return redirect()
            ->route('research-projects.index')
            ->with('success', 'Research project berhasil dihapus.');
    }

    public function removeFeaturedImage(ResearchProject $researchProject)
    {
        $this->projectService->removeFeaturedImage($researchProject);

        return redirect()
            ->route('research-projects.edit', $researchProject)
            ->with('success', 'Featured image berhasil dihapus.');
    }
}
