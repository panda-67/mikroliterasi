@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi'))

@section('content')
    {{-- Hero --}}
    <section class="border-b border-border bg-background">
        <div class="mx-auto max-w-300 px-6 py-20 lg:px-8 lg:py-28">
            <div class="max-w-3xl">
                <p class="mb-4 text-sm font-semibold uppercase tracking-wider text-primary">
                    Research & Conservation
                </p>

                <h1 class="text-4xl font-semibold leading-tight tracking-tight text-text sm:text-5xl lg:text-6xl">
                    Research, knowledge, and conservation in practice.
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-text-muted">
                    Mikroliterasi develops and shares research-based knowledge
                    to support the understanding, conservation, and sustainable
                    management of biodiversity and natural ecosystems.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a
                        href="{{ route('research-projects.index') }}"
                        class="inline-flex items-center justify-center rounded-md bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-hover"
                    >
                        Explore Research
                    </a>

                    <a
                        href="{{ route('about') }}"
                        class="inline-flex items-center justify-center rounded-md border border-border-strong bg-surface px-5 py-2.5 text-sm font-medium text-text hover:border-primary hover:text-primary"
                    >
                        About Mikroliterasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Overview --}}
    <section class="bg-surface">
        <div class="mx-auto max-w-300 px-6 py-16 lg:px-8 lg:py-20">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-wider text-primary">
                    What we do
                </p>

                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-text">
                    Research as the foundation
                </h2>

                <p class="mt-4 text-base leading-7 text-text-muted">
                    Our work brings together field research, spatial analysis,
                    biodiversity assessment, and scientific communication to
                    produce useful knowledge for conservation and environmental
                    management.
                </p>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-3">
                <article class="border-t border-border pt-5">
                    <h3 class="text-lg font-semibold text-text">
                        Research
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-text-muted">
                        Ongoing and completed research on biodiversity,
                        ecosystems, and conservation.
                    </p>
                </article>

                <article class="border-t border-border pt-5">
                    <h3 class="text-lg font-semibold text-text">
                        Publications
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-text-muted">
                        Scientific publications, reports, and other
                        research outputs.
                    </p>
                </article>

                <article class="border-t border-border pt-5">
                    <h3 class="text-lg font-semibold text-text">
                        People
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-text-muted">
                        Researchers and collaborators contributing to
                        evidence-based conservation.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- Research CTA --}}
    <section class="bg-background">
        <div class="mx-auto max-w-205 px-6 py-16 text-center lg:py-20">
            <h2 class="text-3xl font-semibold tracking-tight text-text">
                Explore our research
            </h2>

            <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-text-muted">
                Browse current and completed projects and learn more about
                the research behind our work.
            </p>

            <a
                href="{{ route('research-projects.index') }}"
                class="mt-7 inline-flex items-center justify-center rounded-md bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-hover"
            >
                View Research Projects
            </a>
        </div>
    </section>
@endsection
