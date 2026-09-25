@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | ' . $teachingMaterial->title)

@section('content')

    {{-- Header --}}
    <section class="border-b border-border">
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8">

            {{-- Breadcrumb --}}
            <nav
                class="mb-6 text-sm text-text-muted"
                aria-label="Breadcrumb"
            >
                <a
                    href="{{ route('teaching-materials.index') }}"
                    class="transition hover:text-text"
                >
                    Teaching Materials
                </a>

                <span class="mx-2" aria-hidden="true">/</span>

                <span class="text-text">
                    {{ $teachingMaterial->title }}
                </span>
            </nav>

            <div class="max-w-4xl">

                <h1 class="text-3xl font-semibold tracking-tight text-text sm:text-4xl">
                    {{ $teachingMaterial->title }}
                </h1>

                @if ($teachingMaterial->description)
                    <p class="mt-4 text-base leading-7 text-text-muted">
                        {{ $teachingMaterial->description }}
                    </p>
                @endif

            </div>

        </div>
    </section>


    {{-- Content --}}
    <section>
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8">

            <div class="max-w-4xl">

                {{-- Presentation --}}
                <div class="rounded-lg border border-border bg-surface p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-lg font-semibold text-text">
                            Presentation
                        </h2>

                        <p class="mt-1 text-sm leading-6 text-text-muted">
                            Access the presentation associated with this teaching material.
                        </p>

                    </div>

                    @can('viewPpt', $teachingMaterial)

                        <a
                            href="{{ $teachingMaterial->ppt_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-hover"
                        >
                            View Presentation
                        </a>

                    @else

                        <p class="text-sm leading-6 text-text-muted">
                            The presentation is available to authorized users.
                            Please sign in with an account that has access.
                        </p>

                    @endcan

                </div>


                {{-- Metadata --}}
                <div class="mt-8 border-t border-border pt-8">

                    <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        <div>
                            <dt class="text-sm font-medium text-text">
                                Created by
                            </dt>

                            <dd class="mt-1 text-sm text-text-muted">
                                {{ $teachingMaterial->creator->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-text">
                                Published
                            </dt>

                            <dd class="mt-1 text-sm text-text-muted">
                                {{ $teachingMaterial->created_at->format('d F Y') }}
                            </dd>
                        </div>

                    </dl>

                </div>


                {{-- Dashboard Edit --}}
                @can('update', $teachingMaterial)

                    <div class="mt-8 border-t border-border pt-8">

                        <a
                            href="{{ route('dashboard.teaching-materials.edit', $teachingMaterial) }}"
                            class="inline-flex items-center rounded-md border border-border-strong px-4 py-2 text-sm font-medium text-text transition hover:bg-background"
                        >
                            Edit Teaching Material
                        </a>

                    </div>

                @endcan

            </div>

        </div>
    </section>

@endsection
