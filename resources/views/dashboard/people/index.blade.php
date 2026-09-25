@extends('layouts.dashboard')

@section('title', 'People | Dashboard | ' . config('app.name', 'Mikroliterasi'))

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
                    People
                </span>
            </nav>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-text sm:text-3xl">
                        People
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                        Manage researchers, collaborators, and contributors associated with research activities.
                    </p>
                </div>

                @can('create', App\Models\Person::class)
                    <a
                        href="{{ route('people.create', [
                            'fromDashboard' => 1,
                        ]) }}"
                        class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                    >
                        New Person
                    </a>
                @endcan

            </div>

        </div>

        {{-- People --}}
        <div class="overflow-hidden rounded-lg border border-border bg-surface">

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-border bg-card">

                        <tr>

                            <th class="px-4 py-3 font-medium text-text">
                                Name
                            </th>

                            <th class="px-4 py-3 font-medium text-text">
                                Position
                            </th>

                            <th class="px-4 py-3 font-medium text-text">
                                Research Projects
                            </th>

                            <th class="px-4 py-3 font-medium text-text">
                                Publications
                            </th>

                            <th class="px-4 py-3 font-medium text-text">
                                Status
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

                        @forelse ($people as $person)

                            <tr class="align-top">

                                {{-- Name --}}
                                <td class="px-4 py-4">

                                    <div class="flex items-center gap-3">

                                        @if ($person->photo)
                                            <img
                                                src="{{ asset('storage/' . $person->photo) }}"
                                                alt="{{ $person->name }}"
                                                class="h-10 w-10 shrink-0 rounded-full object-cover"
                                            >
                                        @else
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-card text-sm font-medium text-text-muted"
                                                aria-hidden="true"
                                            >
                                                {{ strtoupper(substr($person->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="min-w-0">
                                            <a
                                                href="{{ route('people.show', $person->slug) }}"
                                                class="font-medium text-text transition hover:text-primary hover:underline"
                                            >
                                                {{ $person->name }}
                                            </a>

                                            @if ($person->email)
                                                <div class="mt-0.5 text-xs text-text-muted">
                                                    {{ $person->email }}
                                                </div>
                                            @endif
                                        </div>

                                    </div>

                                </td>

                                {{-- Position --}}
                                <td class="px-4 py-4 text-text-muted">
                                    {{ $person->position ?? '—' }}
                                </td>

                                {{-- Research Projects --}}
                                <td class="px-4 py-4">

                                    @if ($person->researchProjects->isNotEmpty())

                                        <div class="space-y-1">

                                            @foreach ($person->researchProjects as $project)
                                                <div>
                                                    <a
                                                        href="{{ route('research-projects.show', $project->slug) }}"
                                                        class="text-text transition hover:text-primary hover:underline"
                                                    >
                                                        {{ $project->title }}
                                                    </a>
                                                </div>
                                            @endforeach

                                        </div>

                                    @else

                                        <span class="text-text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>

                                {{-- Publications --}}
                                <td class="px-4 py-4">

                                    @if ($person->publications->isNotEmpty())

                                        <div class="space-y-1">

                                            @foreach ($person->publications->sortBy('pivot.author_order') as $publication)
                                                <div>
                                                    <a
                                                        href="{{ route('publications.show', $publication->slug) }}"
                                                        class="text-text transition hover:text-primary hover:underline"
                                                    >
                                                        {{ $publication->title }}
                                                    </a>
                                                </div>
                                            @endforeach

                                        </div>

                                    @else

                                        <span class="text-text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4">

                                    @if ($person->status === 'active')
                                        <span class="text-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="text-text-muted">
                                            Inactive
                                        </span>
                                    @endif

                                </td>

                                {{-- Updated --}}
                                <td class="whitespace-nowrap px-4 py-4 text-text-muted">
                                    {{ $person->updated_at?->format('d M Y') ?? '—' }}
                                </td>

                                {{-- Actions --}}
                                @if (auth()->user()->role === 'admin')

                                    <td class="whitespace-nowrap px-4 py-4">

                                        <div class="flex justify-end gap-3">

                                            @can('update', $person)
                                                <a
                                                    href="{{ route('people.edit', [
                                                        'person' => $person,
                                                        'fromDashboard' => 1,
                                                    ]) }}"
                                                    class="text-sm font-medium text-primary hover:underline"
                                                >
                                                    Edit
                                                </a>
                                            @endcan

                                            @can('delete', $person)
                                                <button
                                                    type="button"
                                                    class="text-sm font-medium text-error hover:underline"
                                                    onclick="document.getElementById('delete-person-{{ $person->id }}').showModal()"
                                                >
                                                    Delete
                                                </button>
                                            @endcan

                                        </div>

                                    </td>

                                @endif

                            </tr>

                            {{-- Delete Confirmation --}}
                            @can('delete', $person)

                                <dialog
                                    id="delete-person-{{ $person->id }}"
                                    class="m-auto w-full max-w-md rounded-lg border border-border bg-surface p-0 shadow-xl backdrop:bg-black/40"
                                >
                                    <div class="p-6">

                                        <div class="mb-5">

                                            <h2 class="text-lg font-semibold text-text">
                                                Delete Person
                                            </h2>

                                            <p class="mt-2 text-sm leading-6 text-text-muted">
                                                Are you sure you want to delete
                                                <span class="font-medium text-text">
                                                    {{ $person->name }}
                                                </span>?
                                                This action cannot be undone.
                                            </p>

                                        </div>

                                        <form
                                            action="{{ route('people.destroy', $person) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <input
                                                type="hidden"
                                                name="fromDashboard"
                                                value="1"
                                            >

                                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                                                <button
                                                    type="button"
                                                    onclick="document.getElementById('delete-person-{{ $person->id }}').close()"
                                                    class="inline-flex items-center justify-center rounded-md border border-border px-4 py-2.5 text-sm font-medium text-text transition hover:bg-card"
                                                >
                                                    Cancel
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center rounded-md bg-error px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                                                >
                                                    Delete Person
                                                </button>

                                            </div>

                                        </form>

                                    </div>
                                </dialog>

                            @endcan

                        @empty

                            <tr>

                                <td
                                    colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}"
                                    class="px-4 py-12 text-center"
                                >

                                    <p class="text-sm text-text-muted">
                                        No people found.
                                    </p>

                                    @can('create', App\Models\Person::class)
                                        <a
                                            href="{{ route('people.create', [
                                                'fromDashboard' => 1,
                                            ]) }}"
                                            class="mt-3 inline-block text-sm font-medium text-primary hover:underline"
                                        >
                                            Add the first person
                                        </a>
                                    @endcan

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if ($people->hasPages())
            <div class="mt-6">
                {{ $people->links() }}
            </div>
        @endif

    </div>

@endsection
