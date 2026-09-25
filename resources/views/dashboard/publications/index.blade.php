@extends('layouts.app')

@section('title', 'Publications | Dashboard')

@section('content')

    <section class="border-b border-border">
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 lg:px-8">

            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="text-sm font-medium text-primary">
                        Dashboard
                    </p>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-text sm:text-3xl">
                        Publications
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                        Manage publications associated with research projects and researchers.
                    </p>
                </div>

                @can('create', App\Models\Publication::class)
                    <a
                        href="{{ route('publications.create', ['fromDashboard' => 1]) }}"
                        class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                    >
                        New Publication
                    </a>
                @endcan

            </div>

        </div>
    </section>

    <section>
        <div class="mx-auto w-full max-w-300 px-4 py-8 sm:px-6 lg:px-8">

            @if ($publications->count())

                <div class="overflow-x-auto rounded-lg border border-border bg-surface">
                    <table class="w-full min-w-250 text-left text-sm">

                        <thead class="border-b border-border bg-card">
                            <tr>
                                <th class="px-5 py-4 font-medium text-text">
                                    Title
                                </th>

                                <th class="px-5 py-4 font-medium text-text">
                                    Year
                                </th>

                                <th class="px-5 py-4 font-medium text-text">
                                    Authors
                                </th>

                                <th class="px-5 py-4 font-medium text-text">
                                    Research Projects
                                </th>

                                <th class="px-5 py-4 font-medium text-text">
                                    Updated
                                </th>

                                @if (auth()->user()->role === 'admin')
                                    <th class="px-5 py-4 font-medium text-text">
                                        Actions
                                    </th>
                                @endif
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-border">

                            @foreach ($publications as $publication)

                                <tr class="align-top">

                                    <td class="px-5 py-4">
                                        <a
                                            href="{{ route('publications.show', $publication->slug) }}"
                                            class="font-medium text-text hover:text-primary hover:underline"
                                        >
                                            {{ $publication->title }}
                                        </a>
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-text-muted">
                                        {{ $publication->year }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($publication->people->count())
                                            <div class="space-y-1">
                                                @foreach ($publication->people->sortBy('pivot.author_order') as $person)
                                                    <div class="text-text">
                                                        {{ $person->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-text-muted">
                                                —
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($publication->researchProjects->count())
                                            <div class="space-y-1">
                                                @foreach ($publication->researchProjects as $project)
                                                    <div>
                                                        <a
                                                            href="{{ route('research-projects.show', $project->slug) }}"
                                                            class="text-text hover:text-primary hover:underline"
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

                                    <td class="whitespace-nowrap px-5 py-4 text-text-muted">
                                        {{ $publication->updated_at?->format('d M Y') ?? '—' }}
                                    </td>

                                    @if (auth()->user()->role === 'admin')
                                        <td class="whitespace-nowrap px-5 py-4">

                                            <div class="flex items-center gap-3">

                                                @can('update', $publication)
                                                    <a
                                                        href="{{ route('publications.edit', [
                                                            'publication' => $publication,
                                                            'fromDashboard' => 1]
                                                        ) }}"
                                                        class="text-sm font-medium text-primary hover:underline"
                                                    >
                                                        Edit
                                                    </a>
                                                @endcan

                                                @can('delete', $publication)
                                                    <button
                                                        type="button"
                                                        class="text-sm font-medium text-error hover:underline"
                                                        onclick="document.getElementById('delete-publication-{{ $publication->id }}').showModal()"
                                                    >
                                                        Delete
                                                    </button>
                                                @endcan

                                            </div>

                                        </td>
                                    @endif

                                </tr>

                                @can('delete', $publication)
                                    <dialog
                                        id="delete-publication-{{ $publication->id }}"
                                        class="m-auto w-full max-w-md rounded-lg border border-border bg-surface p-0 shadow-xl"
                                    >
                                        <div class="p-6">

                                            <div class="mb-5">
                                                <h2 class="text-lg font-semibold text-text">
                                                    Delete Publication
                                                </h2>

                                                <p class="mt-2 text-sm leading-6 text-text-muted">
                                                    Are you sure you want to delete
                                                    <span class="font-medium text-text">
                                                        {{ $publication->title }}
                                                    </span>?
                                                    This action cannot be undone.
                                                </p>
                                            </div>

                                            <form
                                                action="{{ route('publications.destroy', $publication) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <input type="hidden" name="fromDashboard" value="1" >

                                                <div class="flex justify-end gap-3">
                                                    <button
                                                        type="button"
                                                        onclick="document.getElementById('delete-publication-{{ $publication->id }}').close()"
                                                        class="rounded-md border border-border px-4 py-2 text-sm font-medium text-text transition hover:bg-card"
                                                    >
                                                        Cancel
                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="rounded-md bg-error px-4 py-2 text-sm font-medium text-white transition hover:opacity-90"
                                                    >
                                                        Delete Publication
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </dialog>
                                @endcan

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $publications->links() }}
                </div>

            @else

                <div class="rounded-lg border border-border bg-surface px-6 py-12 text-center">

                    <h2 class="text-lg font-semibold text-text">
                        No publications found
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-text-muted">
                        There are currently no publications in the database.
                    </p>

                    @can('create', App\Models\Publication::class)
                        <a
                            href="{{ route('publications.create', ['fromDashboard' => 1]) }}"
                            class="mt-5 inline-flex items-center justify-center rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                        >
                            Create Publication
                        </a>
                    @endcan

                </div>

            @endif

        </div>
    </section>

@endsection
