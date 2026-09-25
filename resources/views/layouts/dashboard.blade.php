@extends('layouts.app')

@section('content')

    <div class="mx-auto flex w-full max-w-300 flex-1">

        <aside class="hidden w-60 shrink-0 border-r border-border lg:block">
            <div class="sticky top-20 px-4 py-8">

                <div class="mb-6">
                    <p class="text-xs font-medium uppercase tracking-wide text-text-muted">
                        Management
                    </p>

                    <h2 class="mt-1 text-lg font-semibold text-text">
                        Dashboard
                    </h2>
                </div>

                <nav class="space-y-1">

                    <a
                        href="{{ route('dashboard.index') }}"
                        class="block rounded-md px-3 py-2 text-sm font-medium transition
                            {{ request()->routeIs('dashboard.index')
                                ? 'bg-card text-text'
                                : 'text-text-muted hover:bg-card hover:text-text' }}"
                    >
                        Overview
                    </a>

                    @can('viewAny', App\Models\ResearchArea::class)
                        <a
                            href="{{ route('dashboard.research-areas.index') }}"
                            class="block rounded-md px-3 py-2 text-sm font-medium transition
                                {{ request()->routeIs('dashboard.research-areas.*')
                                    ? 'bg-card text-text'
                                    : 'text-text-muted hover:bg-card hover:text-text' }}"
                        >
                            Research Areas
                        </a>
                    @endcan

                    @can('viewAny', App\Models\ResearchProject::class)
                        <a
                            href="{{ route('dashboard.research-projects.index') }}"
                            class="block rounded-md px-3 py-2 text-sm font-medium transition
                                {{ request()->routeIs('dashboard.research-projects.*')
                                    ? 'bg-card text-text'
                                    : 'text-text-muted hover:bg-card hover:text-text' }}"
                        >
                            Research Projects
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Publication::class)
                        <a
                            href="{{ route('dashboard.publications.index') }}"
                            class="block rounded-md px-3 py-2 text-sm font-medium transition
                                {{ request()->routeIs('dashboard.publications.*')
                                    ? 'bg-card text-text'
                                    : 'text-text-muted hover:bg-card hover:text-text' }}"
                        >
                            Publications
                        </a>
                    @endcan

                </nav>

            </div>
        </aside>

        <div class="min-w-0 flex-1">

            <div class="border-b border-border lg:hidden">
                <nav class="flex gap-1 overflow-x-auto px-4 py-3 sm:px-6">

                    <a
                        href="{{ route('dashboard.index') }}"
                        class="whitespace-nowrap rounded-md px-3 py-2 text-sm font-medium
                            {{ request()->routeIs('dashboard.index')
                                ? 'bg-card text-text'
                                : 'text-text-muted hover:bg-card hover:text-text' }}"
                    >
                        Overview
                    </a>

                    @can('viewAny', App\Models\ResearchArea::class)
                        <a
                            href="{{ route('dashboard.research-areas.index') }}"
                            class="whitespace-nowrap rounded-md px-3 py-2 text-sm font-medium
                                {{ request()->routeIs('dashboard.research-areas.*')
                                    ? 'bg-card text-text'
                                    : 'text-text-muted hover:bg-card hover:text-text' }}"
                        >
                            Research Areas
                        </a>
                    @endcan

                    @can('viewAny', App\Models\ResearchProject::class)
                        <a
                            href="{{ route('dashboard.research-projects.index') }}"
                            class="whitespace-nowrap rounded-md px-3 py-2 text-sm font-medium
                                {{ request()->routeIs('dashboard.research-projects.*')
                                    ? 'bg-card text-text'
                                    : 'text-text-muted hover:bg-card hover:text-text' }}"
                        >
                            Research Projects
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Publication::class)
                        <a
                            href="{{ route('dashboard.publications.index') }}"
                            class="whitespace-nowrap rounded-md px-3 py-2 text-sm font-medium
                                {{ request()->routeIs('dashboard.publications.*')
                                    ? 'bg-card text-text'
                                    : 'text-text-muted hover:bg-card hover:text-text' }}"
                        >
                            Publications
                        </a>
                    @endcan

                </nav>
            </div>

            @yield('dashboard-content')

        </div>

    </div>

@endsection
