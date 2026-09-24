<?php

namespace App\Http\Controllers;

use App\Models\ResearchArea;
use App\Services\ResearchAreaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ResearchAreaController extends Controller implements HasMiddleware
{
    public function __construct(
        protected ResearchAreaService $researchAreaService
    ) {}

    /**
     * Get the middleware the controller should use.
     */
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Display a listing of research areas.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', ResearchArea::class);

        $researchAreas = $this->researchAreaService->getAll();

        return view('dashboard.research-areas.index', compact('researchAreas'));
    }

    /**
     * Show the form for creating a new research area.
     */
    public function create(): View
    {
        Gate::authorize('create', ResearchArea::class);

        return view('dashboard.research-areas.create');
    }

    /**
     * Store a newly created research area.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', ResearchArea::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:research_areas,slug'],
            'description' => ['nullable', 'string'],
        ]);

        $this->researchAreaService->create($data);

        return redirect()
            ->route('dashboard.research-areas.index')
            ->with('success', 'Research area created successfully.');
    }

    /**
     * Show the form for editing the specified research area.
     */
    public function edit(ResearchArea $researchArea): View
    {
        Gate::authorize('update', $researchArea);

        return view(
            'dashboard.research-areas.edit',
            compact('researchArea')
        );
    }

    /**
     * Update the specified research area.
     */
    public function update(
        Request $request,
        ResearchArea $researchArea
    ): RedirectResponse {
        Gate::authorize('update', $researchArea);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('research_areas', 'slug')
                    ->ignore($researchArea->id),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $this->researchAreaService->update($researchArea, $data);

        return redirect()
            ->route('dashboard.research-areas.index')
            ->with('success', 'Research area updated successfully.');
    }

    /**
     * Remove the specified research area.
     */
    public function destroy(
        ResearchArea $researchArea
    ): RedirectResponse {
        Gate::authorize('delete', $researchArea);

        if ($researchArea->researchProjects()->exists()) {
            return back()->with(
                'error',
                'Research area cannot be deleted because it is still used by research projects.'
            );
        }

        $this->researchAreaService->delete($researchArea);

        return redirect()
            ->route('dashboard.research-areas.index')
            ->with('success', 'Research area deleted successfully.');
    }
}
