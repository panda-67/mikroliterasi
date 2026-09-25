@extends('layouts.dashboard')

@section('title', 'Teaching Materials | Dashboard | ' . config('app.name', 'Mikroliterasi'))

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
            Teaching Materials
        </span>
    </nav>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-text sm:text-3xl">
                Teaching Materials
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                Manage teaching materials and presentation links.
            </p>
        </div>

        @can('create', App\Models\TeachingMaterial::class)
            <a
                href="{{ route('dashboard.teaching-materials.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
            >
                New Teaching Material
            </a>
        @endcan

    </div>

</div>

{{-- Teaching Materials --}}
<div class="overflow-hidden rounded-lg border border-border bg-surface">

    <div class="overflow-x-auto">

        <table class="w-full text-left text-sm">

            <thead class="border-b border-border bg-card">

                <tr>

                    <th class="px-4 py-3 font-medium text-text">
                        Teaching Material
                    </th>

                    <th class="px-4 py-3 font-medium text-text">
                        Created By
                    </th>

                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                        <th class="px-4 py-3 text-right font-medium text-text">
                            Actions
                        </th>
                    @endif

                </tr>

            </thead>

            <tbody class="divide-y divide-border">

                @forelse ($teachingMaterials as $teachingMaterial)

                    <tr class="align-top">

                        <td class="px-4 py-4">

                            <div class="font-medium text-text">
                                {{ $teachingMaterial->title }}
                            </div>

                            @if ($teachingMaterial->description)
                                <p class="mt-1 max-w-2xl text-xs leading-5 text-text-muted">
                                    {{ $teachingMaterial->description }}
                                </p>
                            @endif

                        </td>

                        <td class="whitespace-nowrap px-4 py-4 text-text-muted">
                            {{ $teachingMaterial->creator->name }}
                        </td>

                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'editor')

                            <td class="whitespace-nowrap px-4 py-4">

                                <div class="flex justify-end gap-3">

                                    @can('update', $teachingMaterial)
                                        <a
                                            href="{{ route('dashboard.teaching-materials.edit', $teachingMaterial) }}"
                                            class="text-sm font-medium text-text transition hover:underline"
                                        >
                                            Edit
                                        </a>
                                    @endcan

                                    @can('delete', $teachingMaterial)
                                        <button
                                            type="button"
                                            onclick="document.getElementById('delete-teaching-material-{{ $teachingMaterial->id }}').showModal()"
                                            class="text-sm font-medium text-error hover:underline"
                                        >
                                            Delete
                                        </button>
                                    @endcan

                                </div>

                            </td>

                        @endif

                    </tr>

                    {{-- Modal Delete --}}
                    @can('delete', $teachingMaterial)

                        <dialog
                            id="delete-teaching-material-{{ $teachingMaterial->id }}"
                            class="m-auto w-full max-w-md rounded-lg border border-border bg-surface p-0 shadow-xl backdrop:bg-black/40"
                        >
                            <div class="p-6">

                                <div class="mb-5">

                                    <h2 class="text-lg font-semibold text-text">
                                        Delete Teaching Material
                                    </h2>

                                    <p class="mt-2 text-sm leading-6 text-text-muted">
                                        Are you sure you want to delete
                                        <span class="font-medium text-text">
                                            {{ $teachingMaterial->title }}
                                        </span>?
                                        This action cannot be undone.
                                    </p>

                                </div>

                                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                                    <button
                                        type="button"
                                        onclick="document.getElementById('delete-teaching-material-{{ $teachingMaterial->id }}').close()"
                                        class="inline-flex items-center justify-center rounded-md border border-border px-4 py-2.5 text-sm font-medium text-text transition hover:bg-card"
                                    >
                                        Cancel
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('dashboard.teaching-materials.destroy', $teachingMaterial) }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-md bg-error px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90 sm:w-auto"
                                        >
                                            Delete Teaching Material
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </dialog>

                    @endcan

                @empty

                    <tr>

                        <td
                            colspan="{{ in_array(auth()->user()->role, ['admin', 'editor'], true) ? 3 : 2 }}"
                            class="px-4 py-12 text-center"
                        >

                            <p class="text-sm text-text-muted">
                                No teaching materials found.
                            </p>

                            @can('create', App\Models\TeachingMaterial::class)
                                <a
                                    href="{{ route('dashboard.teaching-materials.create') }}"
                                    class="mt-3 inline-block text-sm font-medium text-primary hover:underline"
                                >
                                    Create the first teaching material
                                </a>
                            @endcan

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@if ($teachingMaterials->hasPages())
    <div class="mt-6">
        {{ $teachingMaterials->links() }}
    </div>
@endif

</div>

@endsection
