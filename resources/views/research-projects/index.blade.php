@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Research Projects')

@section('content')

    {{-- Page header --}}
    <section class="border-b border-border">
        <div class="flex flex-col gap-4 mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

            <p class="text-sm font-medium uppercase tracking-wide text-primary">
                Research
            </p>

            <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">
                Research Projects
            </h1>

            <p class="max-w-2xl text-base leading-7 text-text-muted">
                Research projects covering biodiversity, conservation,
                environmental science, and related field studies.
            </p>

            @auth
                <a
                    href="{{ route('research-projects.create') }}"
                    class="inline-flex w-max items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                >
                    Create Project
                </a>
            @endauth

        </div>
    </section>


    {{-- Research projects --}}
    <section>
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-16">

            @if ($projects->count())

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($projects as $project)

                        <article
                            class="flex h-full flex-col overflow-hidden rounded-lg border border-border bg-surface"
                        >

                            {{-- Featured image --}}
                            @if ($project->featured_image_url)
                                <div class="aspect-video overflow-hidden border-b border-border">
                                    <img
                                        src="{{ $project->featured_image_url }}"
                                        alt="{{ $project->title }}"
                                        class="h-full w-full object-cover"
                                    >
                                </div>
                            @endif

                            {{-- Content --}}
                            <div class="flex flex-1 flex-col p-5 sm:p-6">

                                <div class="flex-1">

                                    @if ($project->status)
                                        <p class="text-xs font-medium uppercase tracking-wide text-primary">
                                            {{ $project->status }}
                                        </p>
                                    @endif

                                    <h2 class="mt-2 text-xl font-semibold leading-snug">
                                        <a
                                            href="{{ route('research-projects.show', $project) }}"
                                            class="text-text hover:text-primary"
                                        >
                                            {{ $project->title }}
                                        </a>
                                    </h2>

                                    @if ($project->short_description)
                                        <p class="mt-3 line-clamp-3 text-sm leading-6 text-text-muted">
                                            {{ $project->short_description }}
                                        </p>
                                    @endif

                                </div>


                                {{-- Card footer --}}
                                <div class="mt-6 border-t border-border pt-4">

                                    @if ($project->location)
                                        <p class="text-sm text-text-muted">
                                            {{ $project->location }}
                                        </p>
                                    @endif

                                    <a
                                        href="{{ route('research-projects.show', $project) }}"
                                        class="mt-3 inline-flex text-sm font-medium text-primary hover:text-primary-hover"
                                    >
                                        View project
                                        <span aria-hidden="true" class="ml-1">→</span>
                                    </a>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if ($projects->hasPages())
                    <div class="mt-10 sm:mt-12">
                        {{ $projects->links() }}
                    </div>
                @endif

            @else

                <div class="border border-border bg-surface px-6 py-12 text-center">
                    <h2 class="text-xl font-semibold">
                        No research projects
                    </h2>

                    <p class="mt-2 text-sm text-text-muted">
                        There are currently no research projects to display.
                    </p>
                </div>

            @endif

        </div>
    </section>

@endsection
