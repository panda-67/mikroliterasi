<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeachingMaterialRequest;
use App\Models\TeachingMaterial;
use App\Services\TeachingMaterialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TeachingMaterialController extends Controller implements HasMiddleware
{
    public function __construct(
        protected TeachingMaterialService $teachingMaterialService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: [
                'dashboardIndex',
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ]),
        ];
    }

    public function dashboardIndex()
    {
        Gate::authorize('viewAny', TeachingMaterial::class);

        $teachingMaterials = $this->teachingMaterialService->getAll(12);

        return view('dashboard.teaching-materials.index', compact('teachingMaterials'));
    }

    public function index(): View
    {
        $teachingMaterials = $this->teachingMaterialService->getAll(12);

        return view('teaching-materials.index', compact('teachingMaterials'));
    }

    public function show(
        TeachingMaterial $teachingMaterial
    ): View {
        return view('teaching-materials.show', compact('teachingMaterial'));
    }

    public function create(): View
    {
        Gate::authorize('create', TeachingMaterial::class);

        return view('dashboard.teaching-materials.create');
    }

    public function store(
        TeachingMaterialRequest $request
    ): RedirectResponse {
        Gate::authorize('create', TeachingMaterial::class);

        $this->teachingMaterialService->create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('dashboard.teaching-materials.index')
            ->with('success', 'Teaching material created successfully.');
    }

    public function edit(
        TeachingMaterial $teachingMaterial
    ): View {
        Gate::authorize('update', $teachingMaterial);

        return view('dashboard.teaching-materials.edit', compact('teachingMaterial'));
    }

    public function update(
        TeachingMaterialRequest $request,
        TeachingMaterial $teachingMaterial
    ): RedirectResponse {
        Gate::authorize('update', $teachingMaterial);

        $this->teachingMaterialService->update(
            $teachingMaterial,
            $request->validated()
        );

        return redirect()
            ->route('dashboard.teaching-materials.index')
            ->with(
                'success',
                'Teaching material updated successfully.'
            );
    }

    public function destroy(
        TeachingMaterial $teachingMaterial
    ): RedirectResponse {
        Gate::authorize('delete', $teachingMaterial);

        $this->teachingMaterialService->delete(
            $teachingMaterial
        );

        return redirect()
            ->route('dashboard.teaching-materials.index')
            ->with(
                'success',
                'Teaching material deleted successfully.'
            );
    }
}
