<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchProjectRequest;
use App\Models\Person;
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
        return view('research-projects.show', compact('researchProject'));
    }

    public function create()
    {
        $people = $this->personService->getActive();

        return view('research-projects.create', compact('people'));
    }

    public function store(ResearchProjectRequest $request)
    {
        $data = $request->validated();

        $people = $data['people'] ?? [];
        unset($data['people']);

        $project = $this->projectService->create($data);

        $this->projectService->syncPeople($project, $people);

        return redirect()
            ->route('research-projects.show', $project->slug)
            ->with('success', 'Research project berhasil dibuat.');
    }

    public function edit(ResearchProject $researchProject)
    {
        $researchProject->load('people');
        $people = $this->personService->getActive();

        return view(
            'research-projects.edit',
            compact('researchProject', 'people')
        );
    }

    public function update(ResearchProjectRequest $request, ResearchProject $researchProject)
    {
        $data = $request->validated();

        $people = $data['people'] ?? [];
        unset($data['people']);

        $this->projectService->update($researchProject, $data);

        $this->projectService->syncPeople(
            $researchProject,
            $people
        );

        $project = $researchProject->fresh('people');

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
