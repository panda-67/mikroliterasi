<?php

namespace App\Http\Controllers;

use App\Models\ResearchProject;
use App\Services\ResearchProjectService;
use Illuminate\Http\Request;
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
            new Middleware(
                'auth',
                only: [
                    'create',
                    'store',
                    'edit',
                    'update',
                    'destroy',
                ]
            ),
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:research_projects,slug'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => [
                'required',
                'in:planned,ongoing,completed,archived',
            ],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable', 'string', 'max:255'],
            'funding_source' => ['nullable', 'string', 'max:255'],
        ]);

        $project = $this->projectService->create($data);

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

    public function update(
        Request $request,
        ResearchProject $researchProject
    ) {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:research_projects,slug,' . $researchProject->id,
            ],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => [
                'required',
                'in:planned,ongoing,completed,archived',
            ],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable', 'string', 'max:255'],
            'funding_source' => ['nullable', 'string', 'max:255'],
        ]);

        $project = $this->projectService->update(
            $researchProject,
            $data
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
