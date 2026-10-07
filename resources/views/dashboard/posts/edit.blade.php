@extends('layouts.dashboard')

@section('title', 'Edit Post | Dashboard | ' . config('app.name', 'Mikroliterasi'))

@section('dashboard-content')

<div class="mx-auto w-full max-w-300 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

    {{-- Header --}}
    <div class="mb-8">

        <nav
            class="mb-6 text-sm text-text-muted"
            aria-label="Breadcrumb"
        >
            <a
                href="{{ route('dashboard.posts.index') }}"
                class="text-sm text-text-muted hover:text-primary"
            >
                ← Posts
            </a>
        </nav>

        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-text sm:text-3xl">
                Edit Post
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                Update the post content, publication settings, or featured image.
            </p>
        </div>

    </div>

    {{-- Form --}}
    <div class="rounded-lg border border-border bg-surface p-6 sm:p-8">

        <form
            method="POST"
            action="{{ route('dashboard.posts.update', $post) }}"
            enctype="multipart/form-data"
        >

            @method('PUT')

            @include('dashboard.posts._form')

        </form>

    </div>

</div>

@endsection
