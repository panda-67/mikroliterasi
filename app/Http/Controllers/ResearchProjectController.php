<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchProjectRequest;
use App\Models\ResearchProject;
use App\Services\ResearchProjectService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ResearchProjectController extends Controller implements HasMiddleware
{
    public function __construct(
        protected ResearchProjectService $projectService
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
        return view('research-projects.create');
    }

    public function store(ResearchProjectRequest $request)
    {
        $project = $this->projectService->create(
            $request->validated()
        );

        return redirect()
            ->route('research-projects.show', $project->slug)
            ->with('success', 'Research project berhasil dibuat.');
    }

    public function edit(ResearchProject $researchProject)
    {
        return view(
            'research-projects.edit',
            compact('researchProject')
        );
    }

    public function update(ResearchProjectRequest $request, ResearchProject $researchProject)
    {
        $project = $this->projectService->update(
            $researchProject,
            $request->validated()
        );

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
}
