@extends('layouts.app')

@section('title', 'New Research Area | ' . config('app.name', 'Mikroliterasi'))

@section('content')

<section>
    <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8">

        <div class="mb-8">
            <nav class="mb-3 text-sm text-text-muted" aria-label="Breadcrumb">
                <a
                    href="{{ route('dashboard') }}"
                    class="transition hover:text-text"
                >
                    Dashboard
                </a>

                <span class="mx-2">/</span>

                <a
                    href="{{ route('dashboard.research-areas.index') }}"
                    class="transition hover:text-text"
                >
                    Research Areas
                </a>

                <span class="mx-2">/</span>

                <span class="text-text">
                    New
                </span>
            </nav>

            <h1 class="text-2xl font-semibold tracking-tight text-text">
                New Research Area
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                Add a research area used to categorize research projects.
            </p>
        </div>

        <div class="border border-border bg-card p-5 sm:p-6">
            <form
                method="POST"
                action="{{ route('dashboard.research-areas.store') }}"
            >
                @include('dashboard.research-areas._form', [
                    'submitLabel' => 'Create Research Area',
                ])
            </form>
        </div>

    </div>
</section>

@endsection
