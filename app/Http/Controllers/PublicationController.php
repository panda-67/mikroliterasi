<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicationRequest;
use App\Models\Publication;
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
        $publications = $this->publicationService->getAll(12);

        return view('publications.index', compact('publications'));
    }

    public function create()
    {
        return view('publications.create');
    }

    public function store(PublicationRequest $request)
    {
        $publication = $this->publicationService->create(
            $request->validated()
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
            'people',
            'researchProjects',
        ]);

        return view('publications.show', compact('publication'));
    }

    public function edit(Publication $publication)
    {
        $publication->load([
            'people',
            'researchProjects',
        ]);

        return view('publications.edit', compact('publication'));
    }

    public function update(
        PublicationRequest $request,
        Publication $publication
    ) {
        $publication = $this->publicationService->update(
            $publication,
            $request->validated()
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
