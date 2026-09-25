@extends('layouts.dashboard')

@section('title', 'Research Areas | Dashboard | ' . config('app.name', 'Mikroliterasi'))

@section('dashboard-content')

<div class="mx-auto w-full max-w-300 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

    {{-- Header --}}
    <div class="mb-8">

        <nav
            class="mb-6 text-sm text-text-muted"
            aria-label="Breadcrumb"
        >
            <a
                href="{{ route('dashboard.index') }}"
                class="transition hover:text-text"
            >
                Dashboard
            </a>

            <span class="mx-2" aria-hidden="true">/</span>

            <span class="text-text">
                Research Areas
            </span>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-text sm:text-3xl">
                    Research Areas
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                    Manage the research areas used to categorize research projects.
                </p>
            </div>

            @can('create', App\Models\ResearchArea::class)
                <button
                    type="button"
                    onclick="document.getElementById('create-research-area').showModal()"
                    class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                >
                    New Research Area
                </button>
            @endcan

        </div>

    </div>

    {{-- Research Areas --}}
    <div class="overflow-hidden rounded-lg border border-border bg-surface">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-border bg-card">

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
                                    <p class="mt-1 max-w-2xl text-xs leading-5 text-text-muted">
                                        {{ $researchArea->description }}
                                    </p>
                                @endif

                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-text-muted">
                                {{ $researchArea->research_projects_count }}
                            </td>

                            @if (auth()->user()->role === 'admin')

                                <td class="whitespace-nowrap px-4 py-4">

                                    <div class="flex justify-end gap-3">

                                        @can('update', $researchArea)
                                            <button
                                                type="button"
                                                onclick="document.getElementById('edit-research-area-{{ $researchArea->id }}').showModal()"
                                                class="text-sm font-medium text-text transition hover:underline"
                                            >
                                                Edit
                                            </button>
                                       @endcan

                                        @can('delete', $researchArea)
                                            @if ($researchArea->research_projects_count === 0)
                                                <button
                                                    type="button"
                                                    class="text-sm font-medium text-error hover:underline"
                                                    onclick="document.getElementById('delete-research-area-{{ $researchArea->id }}').showModal()"
                                                >
                                                    Delete
                                                </button>
                                            @endif
                                        @endcan

                                    </div>

                                </td>

                            @endif

                        </tr>

                        {{-- Modal Edit --}}
                        <dialog
                            id="edit-research-area-{{ $researchArea->id }}"
                            class="m-auto w-full max-w-lg rounded-lg border border-border bg-surface p-0 shadow-xl backdrop:bg-black/40"
                        >
                            <div class="p-5 sm:p-6">

                                <div class="mb-6">
                                    <h2 class="text-lg font-semibold text-text">
                                        Edit Research Area
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-text-muted">
                                        Update the research area information.
                                    </p>
                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('dashboard.research-areas.update', $researchArea) }}"
                                >
                                    @method('PUT')

                                    @include('dashboard.research-areas._form', [
                                        'researchArea' => $researchArea,
                                        'nameInputId' => 'edit-research-area-' . $researchArea->id . '-name',
                                        'descriptionInputId' => 'edit-research-area-' . $researchArea->id . '-description',
                                        'modalId' => 'edit-research-area-' . $researchArea->id,
                                        'submitLabel' => 'Save Changes',
                                    ])
                                </form>

                            </div>
                        </dialog>

                        @can('delete', $researchArea)

                            @if ($researchArea->research_projects_count === 0)

                                <dialog
                                    id="delete-research-area-{{ $researchArea->id }}"
                                    class="m-auto w-full max-w-md rounded-lg border border-border bg-surface p-0 shadow-xl backdrop:bg-black/40"
                                >
                                    <div class="p-6">

                                        <div class="mb-5">

                                            <h2 class="text-lg font-semibold text-text">
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
                                                onclick="document.getElementById('delete-research-area-{{ $researchArea->id }}').close()"
                                                class="inline-flex items-center justify-center rounded-md border border-border px-4 py-2.5 text-sm font-medium text-text transition hover:bg-card"
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
                                                    class="inline-flex w-full items-center justify-center rounded-md bg-error px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90 sm:w-auto"
                                                >
                                                    Delete Research Area
                                                </button>
                                            </form>

                                        </div>

                                    </div>
                                </dialog>

                            @endif

                        @endcan

                    @empty

                        <tr>

                            <td
                                colspan="{{ auth()->user()->role === 'admin' ? 3 : 2 }}"
                                class="px-4 py-12 text-center"
                            >

                                <p class="text-sm text-text-muted">
                                    No research areas found.
                                </p>

                                @can('create', App\Models\ResearchArea::class)
                                    <a
                                        href="{{ route('dashboard.research-areas.create') }}"
                                        class="mt-3 inline-block text-sm font-medium text-primary hover:underline"
                                    >
                                        Create the first research area
                                    </a>
                                @endcan

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Modal Create --}}
        <dialog
            id="create-research-area"
            class="m-auto w-full max-w-lg rounded-lg border border-border bg-surface p-0 shadow-xl backdrop:bg-black/40"
        >
            <div class="p-5 sm:p-6">

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-text">
                        New Research Area
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-text-muted">
                        Add a research area used to categorize research projects.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('dashboard.research-areas.store') }}"
                >
                    @include('dashboard.research-areas._form', [
                        'researchArea' => null,
                        'nameInputId' => 'create-research-area-name',
                        'descriptionInputId' => 'create-research-area-description',
                        'modalId' => 'create-research-area',
                        'submitLabel' => 'Create Research Area',
                    ])
                </form>

            </div>
        </dialog>

    </div>

    @if ($researchAreas->hasPages())
        <div class="mt-6">
            {{ $researchAreas->links() }}
        </div>
    @endif

</div>

@endsection
