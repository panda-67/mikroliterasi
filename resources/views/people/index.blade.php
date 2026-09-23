@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | People')

@section('content')

{{-- Header --}}
<section class="border-b border-border">
    <div class="flex flex-col gap-4 mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

        <p class="text-sm font-medium uppercase tracking-wide text-primary">
            Research teams
        </p>

        <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">
            People
        </h1>

        <p class="max-w-2xl text-base leading-7 text-text-muted">
            Researchers and members contributing to Mikroliterasi.
        </p>

        @auth
            <a
                href="{{ route('people.create') }}"
                class="inline-flex shrink-0 w-max items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
            >
                Add Person
            </a>
        @endauth

    </div>
</section>


<div class="mx-auto w-full max-w-300 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

    {{-- People list --}}
    @if ($people->isNotEmpty())

        <div class="divide-y divide-border border-y border-border">

            @foreach ($people as $person)

                <article class="py-5 first:pt-5 last:pb-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0">

                            <h2 class="text-base font-semibold text-text">
                                <a
                                    href="{{ route('people.show', $person->slug) }}"
                                    class="hover:text-primary"
                                >
                                    {{ $person->name }}
                                </a>
                            </h2>

                            @if ($person->position)
                                <p class="mt-1 text-sm text-text-muted">
                                    {{ $person->position }}
                                </p>
                            @endif

                            @if ($person->short_bio)
                                <p class="mt-3 max-w-3xl text-sm leading-6 text-text-muted">
                                    {{ $person->short_bio }}
                                </p>
                            @endif

                        </div>


                        {{-- Status --}}
                        <div class="shrink-0">

                            @if ($person->status === 'active')
                                <span class="inline-flex rounded-full bg-success/10 px-2.5 py-1 text-xs font-medium text-success">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-background px-2.5 py-1 text-xs font-medium text-text-muted">
                                    Inactive
                                </span>
                            @endif

                        </div>

                    </div>

                </article>

            @endforeach

        </div>


        {{-- Pagination --}}
        @if ($people->hasPages())
            <div class="mt-8">
                {{ $people->links() }}
            </div>
        @endif

    @else

        <div class="border-y border-border py-12 text-center">

            <h2 class="text-lg font-semibold text-text">
                No people found
            </h2>

            <p class="mt-2 text-sm text-text-muted">
                There are no researchers or members available yet.
            </p>

            @auth
                <a
                    href="{{ route('people.create') }}"
                    class="mt-5 inline-flex rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                >
                    Create Person
                </a>
            @endauth

        </div>

    @endif

</div>

@endsection
