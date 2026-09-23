@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Publications')

@section('content')

    {{-- Header --}}
    <section class="border-b border-border">
        <div class="flex flex-col gap-4 mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

            <p class="text-sm font-medium uppercase tracking-wide text-primary">
                Research outputs
            </p>

            <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">
                Publications
            </h1>

            <p class="max-w-2xl text-base leading-7 text-text-muted">
                Research publications and scholarly outputs.
            </p>

            @auth
                <a
                    href="{{ route('publications.create') }}"
                    class="inline-flex shrink-0 w-max items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                >
                    Add Publication
                </a>
            @endauth

        </div>
    </section>


    {{-- Publications --}}
    <section>
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-8 sm:py-12">

            @if ($publications->isNotEmpty())

                <div class="divide-y divide-border border-y border-border py-8">

                    @foreach ($publications as $publication)

                        <article class="py-6 first:pt-0 last:pb-0">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <h2 class="text-lg font-semibold leading-7 text-text">
                                        <a
                                            href="{{ route('publications.show', $publication->slug) }}"
                                            class="hover:text-primary"
                                        >
                                            {{ $publication->title }}
                                        </a>
                                    </h2>

                                    <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-text-muted">

                                        @if ($publication->year)
                                            <span>{{ $publication->year }}</span>
                                        @endif

                                        @if ($publication->publication_type)
                                            <span>
                                                {{ str_replace('_', ' ', ucfirst($publication->publication_type)) }}
                                            </span>
                                        @endif

                                        @if ($publication->journal)
                                            <span>{{ $publication->journal }}</span>
                                        @endif

                                    </div>

                                    @if ($publication->abstract)
                                        <p class="mt-3 line-clamp-2 text-sm leading-6 text-text-muted">
                                            {{ $publication->abstract }}
                                        </p>
                                    @endif

                                </div>

                                <a
                                    href="{{ route('publications.show', $publication->slug) }}"
                                    class="shrink-0 text-sm font-medium text-primary hover:text-primary-hover"
                                >
                                    View
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if ($publications->hasPages())
                    <div class="mt-8">
                        {{ $publications->links() }}
                    </div>
                @endif

            @else

                {{-- Empty state --}}
                <div class="border-y border-border py-16 text-center">

                    <h2 class="text-lg font-semibold text-text">
                        No publications found
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-text-muted">
                        There are no publications available in the research database yet.
                    </p>

                    @auth
                        <a
                            href="{{ route('publications.create') }}"
                            class="mt-6 inline-flex rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                        >
                            Add Publication
                        </a>
                    @endauth

                </div>

            @endif

        </div>
    </section>

@endsection
