@extends('layouts.app')

@section('title', $publication->title)

@section('content')

    {{-- Header --}}
    <section class="border-b border-border">
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

            {{-- Breadcrumb --}}
            <nav class="text-sm text-text-muted" aria-label="Breadcrumb">
                <a
                    href="{{ route('publications.index') }}"
                    class="hover:text-primary"
                >
                    Publications
                </a>

                <span class="mx-2" aria-hidden="true">/</span>

                <span class="text-text">
                    {{ $publication->title }}
                </span>
            </nav>

            {{-- Publication type --}}
            @if ($publication->publication_type)
                <p class="mt-8 text-sm font-medium uppercase tracking-wide text-primary">
                    {{ str_replace('_', ' ', $publication->publication_type) }}
                </p>
            @endif

            {{-- Title --}}
            <h1 class="mt-2 max-w-4xl text-3xl font-semibold leading-16 tracking-tight sm:text-4xl lg:text-5xl">
                {{ $publication->title }}
            </h1>

            {{-- Metadata --}}
            <div class="mt-5 flex flex-wrap gap-x-3 gap-y-1 text-lg leading-8 text-text-muted">

                @if ($publication->year)
                    <span>{{ $publication->year }}</span>
                @endif

                @if ($publication->journal)
                    <span aria-hidden="true">·</span>
                    <span>{{ $publication->journal }}</span>
                @endif

                @if ($publication->publisher)
                    <span aria-hidden="true">·</span>
                    <span>{{ $publication->publisher }}</span>
                @endif

            </div>

            {{-- Action --}}
            @auth
                <div class="mt-6 flex flex-wrap items-center gap-3">

                    <a
                        href="{{ route('publications.edit', $publication) }}"
                        class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                    >
                        Edit Publication
                    </a>

                    <form
                        action="{{ route('publications.destroy', $publication) }}"
                        method="POST"
                        id="delete-publication-form"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="button"
                            id="delete-publication-button"
                            class="rounded-md border border-error px-4 py-2 text-sm font-medium text-error hover:bg-error-light"
                        >
                            Delete Publication
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

                    {{-- Publication details --}}
                    <section>
                        <h2 class="text-2xl font-semibold text-text">
                            Publication details
                        </h2>

                        <div class="mt-6 divide-y divide-border border-y border-border">

                            @if ($publication->journal)
                                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm text-text-muted">
                                        Journal
                                    </dt>

                                    <dd class="text-sm text-text sm:col-span-2">
                                        {{ $publication->journal }}
                                    </dd>
                                </div>
                            @endif

                            @if ($publication->publisher)
                                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm text-text-muted">
                                        Publisher
                                    </dt>

                                    <dd class="text-sm text-text sm:col-span-2">
                                        {{ $publication->publisher }}
                                    </dd>
                                </div>
                            @endif

                            @if ($publication->year)
                                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm text-text-muted">
                                        Year
                                    </dt>

                                    <dd class="text-sm text-text sm:col-span-2">
                                        {{ $publication->year }}
                                    </dd>
                                </div>
                            @endif

                            @if ($publication->volume)
                                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm text-text-muted">
                                        Volume
                                    </dt>

                                    <dd class="text-sm text-text sm:col-span-2">
                                        {{ $publication->volume }}
                                    </dd>
                                </div>
                            @endif

                            @if ($publication->issue)
                                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm text-text-muted">
                                        Issue
                                    </dt>

                                    <dd class="text-sm text-text sm:col-span-2">
                                        {{ $publication->issue }}
                                    </dd>
                                </div>
                            @endif

                            @if ($publication->pages)
                                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm text-text-muted">
                                        Pages
                                    </dt>

                                    <dd class="text-sm text-text sm:col-span-2">
                                        {{ $publication->pages }}
                                    </dd>
                                </div>
                            @endif

                        </div>
                    </section>


                    {{-- Abstract --}}
                    @if ($publication->abstract)
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold text-text">
                                Abstract
                            </h2>

                            <div class="mt-5 text-sm leading-7 text-text">
                                {!! nl2br(e($publication->abstract)) !!}
                            </div>

                        </section>
                    @endif


                    {{-- Authors --}}
                    @if ($publication->people->isNotEmpty())
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold text-text">
                                Authors
                            </h2>

                            <div class="mt-6 divide-y divide-border border-y border-border">

                                @foreach ($publication->people->sortBy('pivot.author_order') as $person)

                                    <div class="py-4 first:pt-4 last:pb-4">

                                        <div class="flex items-start justify-between gap-4">

                                            <div class="min-w-0">

                                                <p class="text-sm font-medium text-text">
                                                    {{ $person->name }}
                                                </p>

                                                @if ($person->position)
                                                    <p class="mt-1 text-sm text-text-muted">
                                                        {{ $person->position }}
                                                    </p>
                                                @endif

                                            </div>

                                            @if ($person->pivot->author_order)
                                                <span class="shrink-0 text-xs text-text-subtle">
                                                    {{ $person->pivot->author_order }}
                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </section>
                    @endif


                    {{-- Research projects --}}
                    @if ($publication->researchProjects->isNotEmpty())
                        <section class="mt-12 border-t border-border pt-8">

                            <h2 class="text-2xl font-semibold text-text">
                                Research projects
                            </h2>

                            <div class="mt-6 divide-y divide-border border-y border-border">

                                @foreach ($publication->researchProjects as $project)

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

                </main>


                {{-- Sidebar --}}
                <aside>

                    <div class="lg:sticky lg:top-8">

                        <h2 class="text-base font-semibold text-text">
                            Publication information
                        </h2>

                        <dl class="mt-5 divide-y divide-border border-y border-border">

                            <div class="py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                    Type
                                </dt>

                                <dd class="mt-1 text-sm text-text">
                                    {{ str_replace('_', ' ', ucfirst($publication->publication_type)) }}
                                </dd>
                            </div>

                            @if ($publication->doi)
                                <div class="py-4">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        DOI
                                    </dt>

                                    <dd class="mt-1 break-all text-sm">
                                        <a
                                            href="https://doi.org/{{ $publication->doi }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-primary hover:text-primary-hover"
                                        >
                                            {{ $publication->doi }}
                                        </a>
                                    </dd>
                                </div>
                            @endif

                            @if ($publication->url)
                                <div class="py-4">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                        External link
                                    </dt>

                                    <dd class="mt-1 text-sm">
                                        <a
                                            href="{{ $publication->url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-primary hover:text-primary-hover"
                                        >
                                            View publication
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
                    href="{{ route('publications.index') }}"
                    class="text-sm text-text-muted hover:text-primary"
                >
                    ← Back to Publications
                </a>

            </div>

        </div>
    </section>


    {{-- Delete modal --}}
    @auth
        <div
            id="delete-publication-modal"
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
        >
            <div
                class="w-full max-w-md rounded-lg border border-border bg-surface p-6 shadow-xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="delete-publication-modal-title"
            >

                <h2
                    id="delete-publication-modal-title"
                    class="text-lg font-semibold text-text"
                >
                    Delete Publication
                </h2>

                <p class="mt-2 text-sm leading-6 text-text-muted">
                    Are you sure you want to delete this publication?
                    This action cannot be undone.
                </p>

                <div class="mt-6 flex justify-end gap-3">

                    <button
                        type="button"
                        id="close-delete-publication-modal"
                        class="rounded-md border border-border-strong px-4 py-2 text-sm font-medium text-text hover:bg-background"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        form="delete-publication-form"
                        class="rounded-md bg-error px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                    >
                        Delete Publication
                    </button>

                </div>

            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById(
                    'delete-publication-modal'
                );

                const openButton = document.getElementById(
                    'delete-publication-button'
                );

                const closeButton = document.getElementById(
                    'close-delete-publication-modal'
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
