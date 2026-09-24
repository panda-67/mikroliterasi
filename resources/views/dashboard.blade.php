@extends('layouts.app')

@section('title', 'Dashboard | ' . config('app.name', 'Mikroliterasi'))

@section('content')

    <section class="border-b border-border">
        <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8">

            <div class="mb-8">
                <p class="text-sm text-text-muted">
                    Management
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-text">
                    Dashboard
                </h1>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                <a
                    href="{{ route('dashboard.research-areas.index') }}"
                    class="group border border-border bg-card p-5 transition hover:border-text"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="font-semibold text-text">
                                Research Areas
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-text-muted">
                                Manage research taxonomy used to categorize research projects.
                            </p>
                        </div>

                        <span
                            class="text-text-muted transition-transform group-hover:translate-x-1"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </div>
                </a>

            </div>

        </div>
    </section>

@endsection
