@extends('layouts.dashboard')

@section('title', 'Dashboard | ' . config('app.name', 'Mikroliterasi'))

@section('dashboard-content')

    <div class="mx-auto w-full max-w-300 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <p class="text-xs font-medium uppercase tracking-wide text-text-muted">
                Management
            </p>

            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-text">
                Dashboard
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                Overview of research content managed through Mikroliterasi.
            </p>
        </div>

        {{-- Content summary --}}
        <div class="grid gap-4 sm:grid-cols-3">

            @can('viewAny', App\Models\ResearchArea::class)
                <a
                    href="{{ route('dashboard.research-areas.index') }}"
                    class="rounded-lg border border-border bg-surface p-5 transition hover:bg-card"
                >
                    <p class="text-sm text-text-muted">
                        Research Areas
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight text-text">
                        {{ $researchAreasCount }}
                    </p>

                    <p class="mt-3 text-xs text-text-muted">
                        Manage research taxonomy
                    </p>
                </a>
            @endcan

            @can('viewAny', App\Models\ResearchProject::class)
                <a
                    href="{{ route('dashboard.research-projects.index') }}"
                    class="rounded-lg border border-border bg-surface p-5 transition hover:bg-card"
                >
                    <p class="text-sm text-text-muted">
                        Research Projects
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight text-text">
                        {{ $researchProjectsCount }}
                    </p>

                    <p class="mt-3 text-xs text-text-muted">
                        Manage research projects
                    </p>
                </a>
            @endcan

            @can('viewAny', App\Models\Publication::class)
                <a
                    href="{{ route('dashboard.publications.index') }}"
                    class="rounded-lg border border-border bg-surface p-5 transition hover:bg-card"
                >
                    <p class="text-sm text-text-muted">
                        Publications
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight text-text">
                        {{ $publicationsCount }}
                    </p>

                    <p class="mt-3 text-xs text-text-muted">
                        Manage publications
                    </p>
                </a>
            @endcan

            @can('viewAny', App\Models\Person::class)
                <a
                    href="{{ route('dashboard.people.index') }}"
                    class="rounded-lg border border-border bg-surface p-5 transition hover:bg-card"
                >
                    <p class="text-sm text-text-muted">
                        People
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight text-text">
                        {{ $peopleCount }}
                    </p>

                    <p class="mt-3 text-xs text-text-muted">
                        Manage people
                    </p>
                </a>
            @endcan

            @can('viewAny', App\Models\TeachingMaterial::class)
                <a
                    href="{{ route('dashboard.teaching-materials.index') }}"
                    class="rounded-lg border border-border bg-surface p-5 transition hover:bg-card"
                >
                    <p class="text-sm text-text-muted">
                        Teaching Materials
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight text-text">
                        {{ $teachingMaterialCount }}
                    </p>

                    <p class="mt-3 text-xs text-text-muted">
                        Manage teaching materials
                    </p>
                </a>
            @endcan

        </div>

    </div>

@endsection
