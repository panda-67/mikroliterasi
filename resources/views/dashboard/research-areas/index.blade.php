@extends('layouts.app')

@section('title', 'Research Areas | ' . config('app.name', 'Mikroliterasi'))

@section('content')

<section>
    <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4">

            <nav class="mb-3 text-sm text-text-muted" aria-label="Breadcrumb">
                <a
                    href="{{ route('dashboard') }}"
                    class="transition hover:text-text"
                >
                    Dashboard
                </a>

                <span class="mx-2">/</span>

                <span class="text-text">
                    Research Areas
                </span>
            </nav>

            <h1 class="text-2xl font-semibold tracking-tight text-text">
                Research Areas
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                Manage the research areas used to categorize research projects.
            </p>

            @can('create', App\Models\ResearchArea::class)
                <a
                    href="{{ route('dashboard.research-areas.create') }}"
                    class="inline-flex max-w-max items-center justify-center border border-text bg-text px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90 sm:w-auto"
                >
                    New Research Area
                </a>
            @endcan

        </div>

        {{-- Research Areas --}}
        <div class="overflow-hidden border border-border bg-card">

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">

                    <thead class="border-b border-border bg-background">
                        <tr>
                            <th class="px-4 py-3 font-medium text-text">
                                Research Area
                            </th>

                            <th class="px-4 py-3 font-medium text-text">
                                Projects
                            </th>

                            @if (auth()->user()->role === 'admin')
                                <th class="px-4 py-3 text-right font-medium text-text">
                                    Actions
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border">

                        @forelse ($researchAreas as $researchArea)

                            <tr class="align-top">

                                <td class="px-4 py-4">
                                    <div class="font-medium text-text">
                                        {{ $researchArea->name }}
                                    </div>

                                    @if ($researchArea->description)
                                        <p class="mt-1 max-w-2xl text-sm leading-6 text-text-muted">
                                            {{ $researchArea->description }}
                                        </p>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-text-muted">
                                    {{ $researchArea->research_projects_count }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4">
                                    <div class="flex items-center justify-end gap-3">
                                        @can('update', $researchArea)
                                            <a
                                                href="{{ route('dashboard.research-areas.edit', $researchArea) }}"
                                                class="text-sm font-medium text-text underline-offset-4 hover:underline"
                                            >
                                                Edit
                                            </a>
                                        @endcan

                                        @can('delete', $researchArea)
                                            @if ($researchArea->research_projects_count === 0)
                                                <button
                                                    type="button"
                                                    onclick="document.getElementById('delete-modal-{{ $researchArea->id }}').showModal()"
                                                    class="text-sm font-medium text-red-700 underline-offset-4 hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            @endif
                                        @endcan

                                    </div>
                                </td>

                            </tr>

                            @can('delete', $researchArea)
                                <dialog
                                    id="delete-modal-{{ $researchArea->id }}"
                                    class="fixed inset-0 m-auto w-[calc(100%-2rem)] max-w-md border border-border bg-card p-0 text-text shadow-xl backdrop:bg-black/40"
                                >
                                    <div class="p-6">

                                        <div class="mb-5">
                                            <h2 class="text-lg font-semibold">
                                                Delete Research Area
                                            </h2>

                                            <p class="mt-2 text-sm leading-6 text-text-muted">
                                                Are you sure you want to delete
                                                <span class="font-medium text-text">
                                                    {{ $researchArea->name }}
                                                </span>?
                                                This action cannot be undone.
                                            </p>
                                        </div>

                                        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                                            <button
                                                type="button"
                                                onclick="document.getElementById('delete-modal-{{ $researchArea->id }}').close()"
                                                class="inline-flex items-center justify-center border border-border px-4 py-2.5 text-sm font-medium text-text transition hover:bg-background"
                                            >
                                                Cancel
                                            </button>

                                            <form
                                                method="POST"
                                                action="{{ route('dashboard.research-areas.destroy', $researchArea) }}"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex w-full items-center justify-center border border-red-700 bg-red-700 px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90 sm:w-auto"
                                                >
                                                    Delete Research Area
                                                </button>
                                            </form>

                                        </div>

                                    </div>
                                </dialog>
                            @endcan

                        @empty

                            <tr>
                                <td
                                    colspan="3"
                                    class="px-4 py-12 text-center"
                                >
                                    <p class="text-sm text-text-muted">
                                        No research areas found.
                                    </p>

                                    <a
                                        href="{{ route('dashboard.research-areas.create') }}"
                                        class="mt-3 inline-block text-sm font-medium text-text underline underline-offset-4"
                                    >
                                        Create the first research area
                                    </a>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- Pagination --}}
        @if ($researchAreas->hasPages())
            <div class="mt-6">
                {{ $researchAreas->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
