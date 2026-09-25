<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicationRequest;
use App\Models\Person;
use App\Models\Publication;
use App\Models\ResearchProject;
use App\Services\PublicationService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PublicationController extends Controller implements HasMiddleware
{
    public function __construct(
        protected PublicationService $publicationService
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
        Gate::authorize('viewAny', Publication::class);

        $publications = $this->publicationService->getAll(12);

        return view('dashboard.publications.index', compact('publications'));
    }

    public function index()
    {
        $publications = $this->publicationService->getAll(12);

        return view('publications.index', compact('publications'));
    }

    public function create(Request $request)
    {
        Gate::authorize('create', Publication::class);

        $researchProjects = ResearchProject::query()
            ->orderBy('title')
            ->get();

        $people = Person::query()
            ->orderBy('name')
            ->get();

        $fromDashboard = $request->boolean('fromDashboard');

        return view('publications.create', compact(
            'people',
            'researchProjects',
            'fromDashboard'
        ));
    }

    public function store(PublicationRequest $request)
    {
        Gate::authorize('create', Publication::class);

        $data = $request->validated();

        $people = $data['people'] ?? [];
        $researchProjects = $data['research_projects'] ?? [];

        unset(
            $data['people'],
            $data['research_projects']
        );

        $publication = $this->publicationService->create($data);

        $this->publicationService->syncPeople(
            $publication,
            $people
        );

        $this->publicationService->syncResearchProjects(
            $publication,
            $researchProjects
        );

        if ($request->boolean('fromDashboard')) {
            return redirect()
                ->route('dashboard.publications.index')
                ->with('success', 'Publication berhasil dibuat.');
        }

        return redirect()
            ->route('publications.show', $publication->slug)
            ->with(
                'success',
                'Publication berhasil dibuat.'
            );
    }

    public function show(Publication $publication)
    {
        $publication->load([
            'people' => function ($query) {
                $query->orderBy('publication_people.author_order');
            },
            'researchProjects',
        ]);

        return view('publications.show', compact('publication'));
    }

    public function edit(Request $request, Publication $publication)
    {
        Gate::authorize('update', $publication);

        $people = Person::query()
            ->orderBy('name')
            ->get();

        $researchProjects = ResearchProject::query()
            ->orderBy('title')
            ->get();

        $publication->load([
            'people',
            'researchProjects',
        ]);

        $fromDashboard = $request->boolean('fromDashboard');

        return view('publications.edit', compact(
            'publication',
            'people',
            'researchProjects',
            'fromDashboard'
        ));
    }

    public function update(
        PublicationRequest $request,
        Publication $publication
    ) {

        Gate::authorize('update', $publication);

        $data = $request->validated();

        $people = $data['people'] ?? [];
        $researchProjects = $data['research_projects'] ?? [];

        unset(
            $data['people'],
            $data['research_projects']
        );

        $publication = $this->publicationService->update(
            $publication,
            $data
        );

        $this->publicationService->syncPeople(
            $publication,
            $people
        );

        $this->publicationService->syncResearchProjects(
            $publication,
            $researchProjects
        );

        if ($request->boolean('fromDashboard')) {
            return redirect()
                ->route('dashboard.publications.index')
                ->with('success', 'Publication berhasil diperbarui.');
        }

        return redirect()
            ->route('publications.show', $publication->slug)
            ->with(
                'success',
                'Publication berhasil diperbarui.'
            );
    }

    public function destroy(Request $request, Publication $publication)
    {
        Gate::authorize('delete', $publication);

        $this->publicationService->delete($publication);

        if ($request->boolean('fromDashboard')) {
            return redirect()
                ->route('dashboard.publications.index')
                ->with('success', 'Publication berhasil dihapus.');
        }

        return redirect()
            ->route('publications.index')
            ->with(
                'success',
                'Publication berhasil dihapus.'
            );
    }
}
