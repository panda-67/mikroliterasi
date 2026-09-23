@extends('layouts.app')

@php
    $project = $researchProject;

    $publicationTypeLabels = [
        'journal_article' => 'Journal Article',
        'conference_paper' => 'Conference Paper',
        'book' => 'Book',
        'book_chapter' => 'Book Chapter',
        'technical_report' => 'Technical Report',
        'policy_brief' => 'Policy Brief',
        'thesis' => 'Thesis',
        'dataset' => 'Dataset',
        'other' => 'Other',
    ];
@endphp

@section('title', config('app.name', 'Mikroliterasi') . ' | ' . $project->title)

@section('content')

    {{-- Header --}}
    <section class="border-b border-border">
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

            {{-- Breadcrumb --}}
            <nav class="text-sm text-text-muted" aria-label="Breadcrumb">
                <a
                    href="{{ route('research-projects.index') }}"
                    class="hover:text-primary"
                >
                    Research
                </a>

                <span class="mx-2" aria-hidden="true">/</span>

                <span class="text-text">
                    {{ $project->title }}
                </span>
            </nav>

            {{-- Status --}}
            @if ($project->status)
                <p class="mt-8 text-sm font-medium uppercase tracking-wide text-primary">
                    {{ $project->status }}
                </p>
            @endif

            {{-- Title --}}
            <h1 class="mt-2 max-w-4xl text-3xl font-semibold leading-16 tracking-tight sm:text-4xl lg:text-5xl">
                {{ $project->title }}
            </h1>

            {{-- Short description --}}
            @if ($project->short_description)
                <p class="mt-5 max-w-3xl text-lg leading-8 text-text-muted">
                    {{ $project->short_description }}
                </p>
            @endif

            {{-- Action --}}
            @auth
                <div class="mt-6 flex flex-wrap items-center gap-3">

                    <a
                        href="{{ route('research-projects.edit', $project) }}"
                        class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                    >
                        Edit Project
                    </a>

                    <form
                        action="{{ route('research-projects.destroy', $project) }}"
                        method="POST"
                        id="delete-project-form"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="button"
                            id="delete-project-button"
                            class="rounded-md border border-error px-4 py-2 text-sm font-medium text-error hover:bg-error-light"
                        >
                            Delete Project
                        </button>
                    </form>

                </div>
            @endauth

        </div>
    </section>


    {{-- Main content --}}
    <section>
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-16">

            <div class="grid grid-cols-1 gap-10 lg:grid-cols-[minmax(0,1fr)_320px] lg:gap-12">

                {{-- Main column --}}
                <div class="min-w-0">

                    {{-- Featured image --}}
                    @if ($project->featured_image_url)
                        <figure class="overflow-hidden rounded-lg border border-border bg-surface">
                            <div class="aspect-video">
                                <img
                                    src="{{ $project->featured_image_url }}"
                                    alt="{{ $project->title }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>

                            <figcaption class="border-t border-border px-4 py-3 text-xs text-text-muted">
                                Featured image — {{ $project->title }}
                            </figcaption>
                        </figure>
                    @endif

                    {{-- Description --}}
                    @if ($project->description)
                        <article class="mt-8 max-w-3xl">

                            <h2 class="text-2xl font-semibold">
                                About this project
                            </h2>

                            <div class="mt-5 text-base leading-8 text-text">
                                {!! nl2br(e($project->description)) !!}
                            </div>

                        </article>
                    @endif

                    {{-- Research team --}}
                    @if ($project->people->isNotEmpty())
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold">
                                Research team
                            </h2>

                            <div class="mt-6 divide-y divide-border border-y border-border">
                                @foreach ($project->people as $person)
                                    <div class="py-4 first:pt-4 last:pb-4">
                                        <div class="flex items-start justify-between gap-4">

                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-text" >
                                                    {{ $person->name }}
                                                </div>

                                                @if ($person->position)
                                                    <p class="mt-1 text-sm text-text-muted">
                                                        {{ $person->position }}
                                                    </p>
                                                @endif
                                            </div>

                                            @if ($person->pivot->role)
                                                <span class="shrink-0 text-xs text-text-subtle">
                                                    {{ $person->pivot->role }}
                                                </span>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </section>
                    @endif

                    {{-- Research areas --}}
                    @if ($project->researchAreas->isNotEmpty())
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold">
                                Research areas
                            </h2>

                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($project->researchAreas as $area)
                                    <span
                                        class="rounded-md border border-border bg-surface px-3 py-1.5 text-sm text-text"
                                    >
                                        {{ $area->name }}
                                    </span>
                                @endforeach
                            </div>

                        </section>
                    @endif

                    {{-- Publications --}}
                    @if ($project->publications->isNotEmpty())
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold">
                                Publications
                            </h2>

                            <div class="mt-6 divide-y divide-border border-y border-border">
                                @foreach ($project->publications as $publication)
                                    <article class="py-5 first:pt-5 last:pb-5">

                                        <a
                                            href="{{ route('publications.show', $publication->slug) }}"
                                            class="text-base font-medium leading-6 text-primary hover:text-primary-hover"
                                        >
                                            {{ $publication->title }}
                                        </a>

                                        <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-sm text-text-muted">

                                            @if ($publication->year)
                                                <span>
                                                    {{ $publication->year }}
                                                </span>
                                            @endif

                                            @if ($publication->publication_type)
                                                <span>
                                                    {{ $publicationTypeLabels[$publication->publication_type] ?? 'Other' }}
                                               </span>
                                            @endif

                                            @if ($publication->journal)
                                                <span>
                                                    {{ $publication->journal }}
                                                </span>
                                            @endif

                                        </div>

                                        @if ($publication->doi || $publication->url)
                                            <div class="mt-3 flex flex-wrap gap-4 text-sm">

                                                @if ($publication->doi)
                                                    <a
                                                        href="https://doi.org/{{ $publication->doi }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="text-primary hover:text-primary-hover"
                                                    >
                                                        DOI
                                                    </a>
                                                @endif

                                                @if ($publication->url)
                                                    <a
                                                        href="{{ $publication->url }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="text-primary hover:text-primary-hover"
                                                    >
                                                        External link
                                                    </a>
                                                @endif

                                            </div>
                                        @endif

                                    </article>
                                @endforeach
                            </div>

                        </section>
                    @endif

                </div>


                {{-- Metadata sidebar --}}
                <aside>

                    <div class="rounded-lg border border-border bg-surface p-5 sm:p-6">

                        <h2 class="text-base font-semibold">
                            Project information
                        </h2>

                        <dl class="mt-5 divide-y divide-border">

                            @if ($project->location)
                                <div class="py-3 first:pt-0">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        Location
                                    </dt>

                                    <dd class="mt-1 text-sm text-text">
                                        {{ $project->location }}
                                    </dd>
                                </div>
                            @endif


                            @if ($project->start_date)
                                <div class="py-3">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        Start date
                                    </dt>

                                    <dd class="mt-1 text-sm text-text">
                                        {{ $project->start_date->format('d F Y') }}
                                    </dd>
                                </div>
                            @endif


                            @if ($project->end_date)
                                <div class="py-3">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        End date
                                    </dt>

                                    <dd class="mt-1 text-sm text-text">
                                        {{ $project->end_date->format('d F Y') }}
                                    </dd>
                                </div>
                            @endif


                            @if ($project->funding_source)
                                <div class="py-3 last:pb-0">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        Funding
                                    </dt>

                                    <dd class="mt-1 text-sm text-text">
                                        {{ $project->funding_source }}
                                    </dd>
                                </div>
                            @endif

                        </dl>

                    </div>

                </aside>

            </div>

        </div>
    </section>


    {{-- Back link --}}
    <section class="border-t border-border">
        <div class="mx-auto w-full max-w-300 px-4 py-8 sm:px-6 lg:px-8">

            <a
                href="{{ route('research-projects.index') }}"
                class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-hover"
            >
                <span aria-hidden="true" class="mr-1">←</span>
                Back to research projects
            </a>

        </div>
    </section>

    @auth
        <div
            id="delete-project-modal"
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="delete-project-title"
        >
            <div
                class="w-full max-w-md rounded-lg border border-border bg-background p-6 shadow-lg"
            >
                <h2
                    id="delete-project-title"
                    class="text-lg font-semibold text-text"
                >
                    Delete Research Project
                </h2>

                <p class="mt-3 text-sm leading-6 text-text-muted">
                    Are you sure you want to delete
                    <span class="font-medium text-text">
                        {{ $project->title }}
                    </span>?
                </p>

                <p class="mt-2 text-sm leading-6 text-text-muted">
                    This action cannot be undone.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <button
                        type="button"
                        id="cancel-delete"
                        class="rounded-md border border-border px-4 py-2 text-sm font-medium text-text hover:bg-surface"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        id="confirm-delete"
                        class="rounded-md bg-error px-4 py-2 text-sm font-medium text-white hover:bg-error/90"
                    >
                        Delete Project
                    </button>
                </div>
            </div>
        </div>
    @endauth
    @auth
        <script>
            const deleteButton = document.getElementById('delete-project-button');
            const deleteModal = document.getElementById('delete-project-modal');
            const cancelDelete = document.getElementById('cancel-delete');
            const confirmDelete = document.getElementById('confirm-delete');
            const deleteForm = document.getElementById('delete-project-form');

            deleteButton?.addEventListener('click', () => {
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
            });

            cancelDelete?.addEventListener('click', () => {
                closeDeleteModal();
            });

            confirmDelete?.addEventListener('click', () => {
                deleteForm.submit();
            });

            deleteModal?.addEventListener('click', (event) => {
                if (event.target === deleteModal) {
                    closeDeleteModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeDeleteModal();
                }
            });

            function closeDeleteModal() {
                deleteModal.classList.remove('flex');
                deleteModal.classList.add('hidden');
            }
        </script>
    @endauth
@endsection
