@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | ' . $person->name)

@section('content')

    {{-- Header --}}
    <section class="border-b border-border">
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

            {{-- Breadcrumb --}}
            <nav class="text-sm text-text-muted" aria-label="Breadcrumb">

                <a
                    href="{{ route('people.index') }}"
                    class="hover:text-primary"
                >
                    People
                </a>

                <span class="mx-2" aria-hidden="true">/</span>

                <span class="text-text">
                    {{ $person->name }}
                </span>

            </nav>

            {{-- Position --}}
            @if ($person->position)
                <p class="mt-8 text-sm font-medium uppercase tracking-wide text-primary">
                    {{ $person->position }}
                </p>
            @endif

            {{-- Name --}}
            <h1 class="mt-2 max-w-4xl text-3xl font-semibold leading-16 tracking-tight sm:text-4xl lg:text-5xl">
                {{ $person->name }}
            </h1>

            {{-- Short bio --}}
            @if ($person->short_bio)
                <p class="mt-5 max-w-3xl text-lg leading-8 text-text-muted">
                    {{ $person->short_bio }}
                </p>
            @endif

            {{-- Contact --}}
            <div class="mt-5 flex flex-wrap gap-x-3 gap-y-1 text-sm leading-7 text-text-muted">

                @if ($person->email)
                    <a
                        href="mailto:{{ $person->email }}"
                        class="hover:text-primary"
                    >
                        {{ $person->email }}
                    </a>
                @endif

                @if ($person->website)
                    @if ($person->email)
                        <span aria-hidden="true">·</span>
                    @endif

                    <a
                        href="{{ $person->website }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:text-primary"
                    >
                        Website
                    </a>
                @endif

                @if ($person->status)
                    @if ($person->email || $person->website)
                        <span aria-hidden="true">·</span>
                    @endif

                    <span>
                        {{ ucfirst($person->status) }}
                    </span>
                @endif

            </div>

            {{-- Actions --}}
            @auth
                <div class="mt-6 flex flex-wrap items-center gap-3">

                    <a
                        href="{{ route('people.edit', $person) }}"
                        class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                    >
                        Edit Person
                    </a>

                    <form
                        action="{{ route('people.destroy', $person) }}"
                        method="POST"
                        id="delete-person-form"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="button"
                            id="delete-person-button"
                            class="rounded-md border border-error px-4 py-2 text-sm font-medium text-error hover:bg-error-light"
                        >
                            Delete Person
                        </button>
                    </form>

                </div>
            @endauth

        </div>
    </section>


    {{-- Main content --}}
    <section>
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

            <div class="grid grid-cols-1 gap-10 lg:grid-cols-[minmax(0,1fr)_20rem]">

                {{-- Main --}}
                <main class="min-w-0">

                    {{-- Biography --}}
                    @if ($person->bio)
                        <section>

                            <h2 class="text-2xl font-semibold text-text">
                                Biography
                            </h2>

                            <div class="mt-6 text-sm leading-7 text-text">
                                {!! nl2br(e($person->bio)) !!}
                            </div>

                        </section>
                    @endif


                    {{-- Education --}}
                    @if ($person->education)
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold text-text">
                                Education
                            </h2>

                            <div class="mt-5 text-sm leading-7 text-text">
                                {!! nl2br(e($person->education)) !!}
                            </div>

                        </section>
                    @endif


                    {{-- Research interests --}}
                    @if ($person->research_interests)
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold text-text">
                                Research interests
                            </h2>

                            <div class="mt-5 text-sm leading-7 text-text">
                                {!! nl2br(e($person->research_interests)) !!}
                            </div>

                        </section>
                    @endif


                    {{-- Research projects --}}
                    @if ($person->researchProjects->isNotEmpty())
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold text-text">
                                Research projects
                            </h2>

                            <div class="mt-6 divide-y divide-border border-y border-border">

                                @foreach ($person->researchProjects as $project)

                                    <div class="py-5 first:pt-5 last:pb-5">

                                        <a
                                            href="{{ route('research-projects.show', $project->slug) }}"
                                            class="text-sm font-medium text-primary hover:text-primary-hover"
                                        >
                                            {{ $project->title }}
                                        </a>

                                        @if ($project->status)
                                            <p class="mt-1 text-sm text-text-muted">
                                                {{ ucfirst($project->status) }}
                                            </p>
                                        @endif

                                    </div>

                                @endforeach

                            </div>

                        </section>
                    @endif


                    {{-- Publications --}}
                    @if ($person->publications->isNotEmpty())
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold text-text">
                                Publications
                            </h2>

                            <div class="mt-6 divide-y divide-border border-y border-border">

                                @foreach ($person->publications as $publication)

                                    <div class="py-5 first:pt-5 last:pb-5">

                                        <a
                                            href="{{ route('publications.show', $publication->slug) }}"
                                            class="text-sm font-medium text-primary hover:text-primary-hover"
                                        >
                                            {{ $publication->title }}
                                        </a>

                                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-text-muted">

                                            @if ($publication->year)
                                                <span>
                                                    {{ $publication->year }}
                                                </span>
                                            @endif

                                            @if ($publication->publication_type)
                                                <span>
                                                    {{ str_replace('_', ' ', ucfirst($publication->publication_type)) }}
                                                </span>
                                            @endif

                                            @if ($publication->journal)
                                                <span>
                                                    {{ $publication->journal }}
                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </section>
                    @endif

                </main>


                {{-- Sidebar --}}
                <aside>

                    <div class="lg:sticky lg:top-8">

                        <h2 class="text-base font-semibold text-text">
                            Academic information
                        </h2>

                        <dl class="mt-5 divide-y divide-border border-y border-border">

                            {{-- Status --}}
                            <div class="py-4">

                                <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                    Status
                                </dt>

                                <dd class="mt-1 text-sm text-text">
                                    {{ ucfirst($person->status) }}
                                </dd>

                            </div>


                            {{-- Position --}}
                            @if ($person->position)
                                <div class="py-4">

                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        Position
                                    </dt>

                                    <dd class="mt-1 text-sm text-text">
                                        {{ $person->position }}
                                    </dd>

                                </div>
                            @endif


                            {{-- Academic profiles --}}
                            @if ($person->scopus)
                                <div class="py-4">

                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        Scopus
                                    </dt>

                                    <dd class="mt-1 text-sm">

                                        <a
                                            href="{{ $person->scopus }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-primary hover:text-primary-hover"
                                        >
                                            View profile
                                        </a>

                                    </dd>

                                </div>
                            @endif


                            @if ($person->google_scholar)
                                <div class="py-4">

                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        Google Scholar
                                    </dt>

                                    <dd class="mt-1 text-sm">

                                        <a
                                            href="{{ $person->google_scholar }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-primary hover:text-primary-hover"
                                        >
                                            View profile
                                        </a>

                                    </dd>

                                </div>
                            @endif


                            @if ($person->orcid)
                                <div class="py-4">

                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        ORCID
                                    </dt>

                                    <dd class="mt-1 text-sm">

                                        <a
                                            href="{{ $person->orcid }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-primary hover:text-primary-hover"
                                        >
                                            View profile
                                        </a>

                                    </dd>

                                </div>
                            @endif


                            @if ($person->sinta)
                                <div class="py-4">

                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        SINTA
                                    </dt>

                                    <dd class="mt-1 text-sm">

                                        <a
                                            href="{{ $person->sinta }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-primary hover:text-primary-hover"
                                        >
                                            View profile
                                        </a>

                                    </dd>

                                </div>
                            @endif

                        </dl>

                    </div>

                </aside>

            </div>


            {{-- Back --}}
            <div class="mt-12 border-t border-border pt-6">

                <a
                    href="{{ route('people.index') }}"
                    class="text-sm text-text-muted hover:text-primary"
                >
                    ← Back to People
                </a>

            </div>

        </div>
    </section>


    {{-- Delete modal --}}
    @auth
        <div
            id="delete-person-modal"
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
        >
            <div
                class="w-full max-w-md rounded-lg border border-border bg-surface p-6 shadow-xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="delete-person-modal-title"
            >

                <h2
                    id="delete-person-modal-title"
                    class="text-lg font-semibold text-text"
                >
                    Delete Person
                </h2>

                <p class="mt-2 text-sm leading-6 text-text-muted">
                    Are you sure you want to delete this person?
                    This action cannot be undone.
                </p>

                <div class="mt-6 flex justify-end gap-3">

                    <button
                        type="button"
                        id="close-delete-person-modal"
                        class="rounded-md border border-border-strong px-4 py-2 text-sm font-medium text-text hover:bg-background"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        form="delete-person-form"
                        class="rounded-md bg-error px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                    >
                        Delete Person
                    </button>

                </div>

            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const modal = document.getElementById(
                    'delete-person-modal'
                );

                const openButton = document.getElementById(
                    'delete-person-button'
                );

                const closeButton = document.getElementById(
                    'close-delete-person-modal'
                );

                if (!modal || !openButton || !closeButton) {
                    return;
                }

                openButton.addEventListener('click', function () {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });

                closeButton.addEventListener('click', function () {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });

            });
        </script>
    @endauth

@endsection
