@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Teaching Materials')

@section('content')

<div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8">

    {{-- Header --}}
    <div class="mb-10">

        <div class="mb-4 text-sm text-text-muted">
            Teaching Materials
        </div>

        <h1 class="text-3xl font-semibold tracking-tight text-text sm:text-4xl">
            Teaching Materials
        </h1>

        <p class="mt-3 max-w-2xl text-sm leading-6 text-text-muted sm:text-base">
            Teaching materials and presentation resources for learning and research.
        </p>

    </div>

    {{-- Teaching Materials --}}
    <div class="space-y-6">

        @forelse ($teachingMaterials as $teachingMaterial)

            <article
                class="rounded-lg border border-border bg-surface p-6 transition hover:border-border-strong"
            >

                <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                    <div class="max-w-3xl">

                        <h2 class="text-xl font-semibold text-text">
                            <a
                                href="{{ route('teaching-materials.show', $teachingMaterial) }}"
                                class="transition hover:text-primary"
                            >
                                {{ $teachingMaterial->title }}
                            </a>
                        </h2>

                        @if ($teachingMaterial->description)
                            <p class="mt-2 text-sm leading-6 text-text-muted">
                                {{ $teachingMaterial->description }}
                            </p>
                        @endif

                    </div>

                    <div class="shrink-0">

                        @can('viewPpt', $teachingMaterial)
                            <a
                                href="{{ $teachingMaterial->ppt_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-hover"
                            >
                                View Presentation
                            </a>
                        @endcan

                    </div>

                </div>

            </article>

        @empty

            <div class="rounded-lg border border-border bg-surface px-6 py-12 text-center">

                <p class="text-sm text-text-muted">
                    No teaching materials are currently available.
                </p>

            </div>

        @endforelse

    </div>

    {{-- Pagination --}}
    @if ($teachingMaterials->hasPages())
        <div class="mt-8">
            {{ $teachingMaterials->links() }}
        </div>
    @endif

</div>

@endsection
