@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Teaching Materials')

@section('content')

{{-- Header --}}
<section class="border-b border-border">
    <div class="flex flex-col gap-4 mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

        <p class="text-sm font-medium uppercase tracking-wide text-primary">
            Learning resources
        </p>

        <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">
            Teaching Materials
        </h1>

        <p class="max-w-2xl text-base leading-7 text-text-muted">
            Teaching materials and presentation resources for learning and research.
        </p>

    </div>
</section>


{{-- Teaching Materials --}}
<section>
    <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-8 sm:py-12">

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
                                    {!! $teachingMaterial->description !!}
                                </p>
                            @endif

                        </div>

                        <div class="shrink-0">

                            <a
                                href="{{ route('teaching-materials.show', $teachingMaterial) }}"
                                class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-hover"
                            >
                                View
                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <div class="border-y border-border py-16 text-center">

                    <h2 class="text-lg font-semibold text-text">
                        No teaching materials found
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-text-muted">
                        There are no teaching materials currently available.
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
</section>

@endsection
