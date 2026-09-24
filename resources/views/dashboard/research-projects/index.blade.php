@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Research Projects')

@section('content')

<div class="mx-auto w-full max-w-300 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 text-sm text-text-muted">
        <a
            href="{{ route('dashboard') }}"
            class="hover:text-primary"
        >
            Dashboard
        </a>

        <span class="mx-2">/</span>

        <span class="text-text">
            Research Projects
        </span>
    </nav>

    {{-- Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="text-sm font-medium text-text-muted">
                Management
            </p>

            <h1 class="mt-1">
                Research Projects
            </h1>

            <p class="mt-2 text-text-muted">
                Manage research projects published on Mikroliterasi.
            </p>
        </div>

        @can('create', \App\Models\ResearchProject::class)
            <a
                href="{{ route('research-projects.create', ['fromDashboard' => 1]) }}"
                class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-hover"
            >
                New Project
            </a>
        @endcan

    </div>

    {{-- Projects --}}
    <div class="overflow-hidden rounded-lg border border-border bg-surface">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-border bg-card">
                    <tr>
                        <th class="px-4 py-3 font-medium text-text">
                            Project
                        </th>

                        <th class="px-4 py-3 font-medium text-text">
                            Status
                        </th>

                        <th class="px-4 py-3 font-medium text-text">
                            Research Areas
                        </th>

                        <th class="px-4 py-3 font-medium text-text">
                            Updated
                        </th>

                        @if (auth()->user()->role === 'admin')
                            <th class="px-4 py-3 text-right font-medium text-text">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-border">

                    @forelse ($projects as $project)

                        <tr class="align-top">

                            {{-- Project --}}
                            <td class="px-4 py-4">

                                <a
                                    href="{{ route('research-projects.show', $project) }}"
                                    class="font-medium text-text hover:text-primary"
                                >
                                    {{ $project->title }}
                                </a>

                                @if ($project->short_description)
                                    <p class="mt-1 max-w-xl text-xs leading-5 text-text-muted">
                                        {{ $project->short_description }}
                                    </p>
                                @endif

                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4 whitespace-nowrap">

                                <span
                                    class="inline-flex rounded-full border border-border px-2.5 py-1 text-xs font-medium text-text"
                                >
                                    {{ ucfirst($project->status) }}
                                </span>

                            </td>

                            {{-- Research Areas --}}
                            <td class="px-4 py-4">

                                @if ($project->researchAreas->isNotEmpty())

                                    <div class="flex flex-wrap gap-1.5">

                                        @foreach ($project->researchAreas as $researchArea)

                                            <span
                                                class="rounded-md bg-card px-2 py-1 text-xs text-text-muted"
                                            >
                                                {{ $researchArea->name }}
                                            </span>

                                        @endforeach

                                    </div>

                                @else

                                    <span class="text-xs text-text-muted">
                                        —
                                    </span>

                                @endif

                            </td>

                            {{-- Updated --}}
                            <td class="px-4 py-4 whitespace-nowrap text-text-muted">

                                {{ $project->updated_at?->format('d M Y') }}

                            </td>

                            {{-- Actions --}}
                            @if (auth()->user()->role === 'admin')

                                <td class="px-4 py-4">

                                    <div class="flex justify-end gap-3">

                                        @can('update', $project)
                                           <a
                                                href="{{ route('research-projects.edit', [
                                                    'research_project' => $project,
                                                    'fromDashboard' => 1,
                                                ]) }}"
                                            >
                                                Edit
                                            </a>
                                        @endcan

                                        @can('delete', $project)

                                            <form
                                                action="{{ route('research-projects.destroy', $project) }}"
                                                method="POST"
                                                onsubmit="return confirm('Delete this research project?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="text-sm font-medium text-error hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            </form>

                                        @endcan

                                    </div>

                                </td>

                            @endif

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}"
                                class="px-4 py-12 text-center"
                            >
                                <p class="text-sm text-text-muted">
                                    No research projects found.
                                </p>

                                @can('create', \App\Models\ResearchProject::class)
                                    <a
                                        href="{{ route('research-projects.create') }}"
                                        class="mt-3 inline-block text-sm font-medium text-primary hover:underline"
                                    >
                                        Create the first research project
                                    </a>
                                @endcan
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    @if ($projects->hasPages())

        <div class="mt-6">
            {{ $projects->links() }}
        </div>

    @endif

</div>

@endsection
