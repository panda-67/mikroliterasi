<?php

namespace App\Http\Controllers;

use App\Models\ResearchArea;
use App\Services\ResearchAreaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
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
     * Store a newly created research area.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', ResearchArea::class);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.research-areas.index')
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', 'create-research-area');
        }

        $this->researchAreaService->create(
            $validator->validated()
        );

        return redirect()
            ->route('dashboard.research-areas.index')
            ->with('success', 'Research area created successfully.');
    }

    /**
     * Update the specified research area.
     */
    public function update(
        Request $request,
        ResearchArea $researchArea
    ): RedirectResponse {
        Gate::authorize('update', $researchArea);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.research-areas.index')
                ->withErrors($validator)
                ->withInput()
                ->with(
                    'open_modal',
                    'edit-research-area-' . $researchArea->id
                );
        }

        $this->researchAreaService->update(
            $researchArea,
            $validator->validated()
        );

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
