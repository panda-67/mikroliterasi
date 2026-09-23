<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicationRequest;
use App\Models\Person;
use App\Models\Publication;
use App\Models\ResearchProject;
use App\Services\PublicationService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PublicationController extends Controller implements HasMiddleware
{
    public function __construct(
        protected PublicationService $publicationService
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
        $publications = $this->publicationService->getAll(12);

        return view('publications.index', compact('publications'));
    }

    public function create()
    {
        $researchProjects = ResearchProject::query()
            ->orderBy('title')
            ->get();

        $people = Person::query()
            ->orderBy('name')
            ->get();

        return view('publications.create', compact('people', 'researchProjects'));
    }

    public function store(PublicationRequest $request)
    {
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

    public function edit(Publication $publication)
    {
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

        return view('publications.edit', compact('publication', 'people', 'researchProjects'));
    }

    public function update(
        PublicationRequest $request,
        Publication $publication
    ) {

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

        return redirect()
            ->route('publications.show', $publication->slug)
            ->with(
                'success',
                'Publication berhasil diperbarui.'
            );
    }

    public function destroy(Publication $publication)
    {
        $this->publicationService->delete($publication);

        return redirect()
            ->route('publications.index')
            ->with(
                'success',
                'Publication berhasil dihapus.'
            );
    }
}
