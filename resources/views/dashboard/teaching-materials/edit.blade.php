@extends('layouts.dashboard')

@section('title', 'Edit Teaching Material | Dashboard | ' . config('app.name', 'Mikroliterasi'))

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

            <a
                href="{{ route('dashboard.teaching-materials.index') }}"
                class="transition hover:text-text"
            >
                Teaching Materials
            </a>

            <span class="mx-2" aria-hidden="true">/</span>

            <span class="text-text">
                Edit
            </span>
        </nav>

        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-text sm:text-3xl">
                Edit Teaching Material
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                Update the teaching material and its presentation link.
            </p>
        </div>

    </div>

    {{-- Form --}}
    <div class="rounded-lg border border-border bg-surface p-6 sm:p-8">

        <form
            method="POST"
            action="{{ route('dashboard.teaching-materials.update', $teachingMaterial) }}"
        >
            @method('PUT')

            @include('dashboard.teaching-materials._form')

        </form>

    </div>

</div>

@endsection
