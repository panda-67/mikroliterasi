@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | About')

@section('content')
    {{-- Header --}}
    <section class="border-b border-border bg-background">
        <div class="mx-auto max-w-205 px-6 py-16 lg:px-8 lg:py-20">
            <p class="text-sm font-semibold uppercase tracking-wider text-primary">
                About Mikroliterasi
            </p>

            <h1 class="mt-3 text-4xl font-semibold tracking-tight text-text sm:text-5xl">
                Research, knowledge, and conservation.
            </h1>

            <p class="mt-6 text-lg leading-8 text-text-muted">
                Mikroliterasi is a research-oriented platform focused on
                developing, documenting, and communicating knowledge about
                biodiversity, ecosystems, and conservation.
            </p>
        </div>
    </section>

    {{-- About --}}
    <section class="bg-surface">
        <div class="mx-auto max-w-205 px-6 py-16 lg:px-8 lg:py-20">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-text">
                    Our approach
                </h2>

                <div class="mt-5 space-y-4 text-base leading-7 text-text-muted">
                    <p>
                        Mikroliterasi places research at the center of its work.
                        We combine field observation, biodiversity assessment,
                        spatial analysis, and data-driven approaches to
                        understand environmental systems and the pressures
                        affecting them.
                    </p>

                    <p>
                        Research findings are documented and communicated as
                        scientific knowledge, research outputs, and practical
                        information that can contribute to conservation and
                        sustainable environmental management.
                    </p>
                </div>
            </div>

            <div class="mt-14 border-t border-border pt-10">
                <h2 class="text-2xl font-semibold tracking-tight text-text">
                    Areas of focus
                </h2>

                <div class="mt-8 grid gap-8 sm:grid-cols-2">
                    <article>
                        <h3 class="text-lg font-semibold text-text">
                            Biodiversity
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-text-muted">
                            Research on species, habitats, ecosystems, and
                            patterns of biological diversity.
                        </p>
                    </article>

                    <article>
                        <h3 class="text-lg font-semibold text-text">
                            Conservation
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-text-muted">
                            Evidence-based approaches to species conservation,
                            habitat protection, and ecological management.
                        </p>
                    </article>

                    <article>
                        <h3 class="text-lg font-semibold text-text">
                            Spatial Research
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-text-muted">
                            GIS, remote sensing, and spatial analysis for
                            understanding ecological and environmental patterns.
                        </p>
                    </article>

                    <article>
                        <h3 class="text-lg font-semibold text-text">
                            Research Communication
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-text-muted">
                            Translating research findings into accessible,
                            documented, and useful knowledge.
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- Research CTA --}}
    <section class="bg-background">
        <div class="mx-auto max-w-205 px-6 py-16 text-center lg:py-20">
            <h2 class="text-2xl font-semibold tracking-tight text-text">
                Explore our research
            </h2>

            <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-text-muted">
                Learn more about the research projects being developed and
                documented by Mikroliterasi.
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
