@extends('layouts.app')

@php
    $categoryLabels = [
        'research_update' => 'Research Update',
        'publication' => 'Publication',
        'field_activity' => 'Field Activity',
        'institutional' => 'Institutional',
        'announcement' => 'Announcement',
    ];
@endphp

@section('title', config('app.name', 'Mikroliterasi') . ' | ' . $post->title)

@section('content')

{{-- Header --}}
<section class="border-b border-border">
    <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-text-muted" aria-label="Breadcrumb">

            <a
                href="{{ route('posts.index') }}"
                class="hover:text-primary"
            >
                Posts
            </a>

            <span class="mx-2" aria-hidden="true">/</span>

            <span class="text-text">
                {{ $post->title }}
            </span>

        </nav>

        {{-- Category --}}
        @if ($post->category)
            <p class="mt-8 text-sm font-medium uppercase tracking-wide text-primary">
                {{ $categoryLabels[$post->category] ?? str_replace('_', ' ', ucfirst($post->category)) }}
            </p>
        @endif

        {{-- Title --}}
        <h1 class="mt-2 max-w-4xl text-3xl font-semibold leading-16 tracking-tight sm:text-4xl lg:text-5xl">
            {{ $post->title }}
        </h1>

        {{-- Excerpt --}}
        @if ($post->excerpt)
            <p class="mt-5 max-w-3xl text-lg leading-8 text-text-muted">
                {{ $post->excerpt }}
            </p>
        @endif

        {{-- Action --}}
        @auth
            @can('update', $post)
                <div class="mt-6 flex flex-wrap items-center gap-3">

                    <a
                        href="{{ route('dashboard.posts.edit', $post) }}"
                        class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                    >
                        Edit Post
                    </a>

                    @can('delete', $post)
                        <form
                            action="{{ route('dashboard.posts.destroy', $post) }}"
                            method="POST"
                            id="delete-post-form"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                id="delete-post-button"
                                class="rounded-md border border-error px-4 py-2 text-sm font-medium text-error hover:bg-error-light"
                            >
                                Delete Post
                            </button>
                        </form>
                    @endcan

                </div>
            @endcan
        @endauth

    </div>
</section>


{{-- Main content --}}
<section>
    <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-16">

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-[minmax(0,1fr)_320px] lg:gap-12">

            {{-- Main column --}}
            <div class="min-w-0">

                {{-- Featured image --}}
                @if ($post->featured_image_url)
                    <figure class="overflow-hidden rounded-lg border border-border bg-surface">

                        <div class="aspect-video">
                            <img
                                src="{{ $post->featured_image_url }}"
                                alt="{{ $post->title }}"
                                class="h-full w-full object-cover"
                            >
                        </div>

                        <figcaption class="border-t border-border px-4 py-3 text-xs text-text-muted">
                            Featured image — {{ $post->title }}
                        </figcaption>

                    </figure>
                @endif


                {{-- Content --}}
                <article class="{{ $post->featured_image ? 'mt-8' : '' }} max-w-3xl">

                    <div class="text-base leading-8 text-text">
                        {!! $post->content !!}
                    </div>

                </article>


                {{-- Research project --}}
                @if ($post->researchProject)
                    <section class="mt-12 border-t border-border pt-8">

                        <h2 class="text-2xl font-semibold">
                            Research project
                        </h2>

                        <div class="mt-6 border-y border-border py-5">

                            <a
                                href="{{ route('research-projects.show', $post->researchProject) }}"
                                class="text-base font-medium text-primary hover:text-primary-hover"
                            >
                                {{ $post->researchProject->title }}
                            </a>

                            @if ($post->researchProject->short_description)
                                <p class="mt-2 text-sm leading-6 text-text-muted">
                                    {{ $post->researchProject->short_description }}
                                </p>
                            @endif

                        </div>

                    </section>
                @endif

            </div>


            {{-- Metadata sidebar --}}
            <aside>

                <div class="rounded-lg border border-border bg-surface p-5 sm:p-6">

                    <h2 class="text-base font-semibold">
                        Post information
                    </h2>

                    <dl class="mt-5 divide-y divide-border">

                        @if ($post->author)
                            <div class="py-3 first:pt-0">

                                <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                    Author
                                </dt>

                                <dd class="mt-1 text-sm text-text">
                                    {{ $post->author->name }}
                                </dd>

                            </div>
                        @endif


                        @if ($post->category)
                            <div class="py-3">

                                <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                    Category
                                </dt>

                                <dd class="mt-1 text-sm text-text">
                                    {{ $categoryLabels[$post->category] ?? str_replace('_', ' ', ucfirst($post->category)) }}
                                </dd>

                            </div>
                        @endif


                        @if ($post->published_at)
                            <div class="py-3">

                                <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                    Published
                                </dt>

                                <dd class="mt-1 text-sm text-text">
                                    {{ $post->published_at->format('d F Y') }}
                                </dd>

                            </div>
                        @endif


                        @if ($post->status)
                            <div class="py-3 last:pb-0">

                                <dt class="text-xs font-medium uppercase tracking-wide text-text-subtle">
                                    Status
                                </dt>

                                <dd class="mt-1 text-sm text-text">
                                    {{ ucfirst($post->status) }}
                                </dd>

                            </div>
                        @endif

                    </dl>

                </div>

            </aside>

        </div>

    </div>
</section>


{{-- Back link --}}
<section class="border-t border-border">
    <div class="mx-auto w-full max-w-300 px-4 py-8 sm:px-6 lg:px-8">

        <a
            href="{{ route('posts.index') }}"
            class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-hover"
        >
            <span aria-hidden="true" class="mr-1">←</span>
            Back to posts
        </a>

    </div>
</section>


{{-- Delete confirmation modal --}}
@auth
    @can('delete', $post)

        <div
            id="delete-post-modal"
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="delete-post-title"
        >
            <div
                class="w-full max-w-md rounded-lg border border-border bg-background p-6 shadow-lg"
            >

                <h2
                    id="delete-post-title"
                    class="text-lg font-semibold text-text"
                >
                    Delete Post
                </h2>

                <p class="mt-3 text-sm leading-6 text-text-muted">
                    Are you sure you want to delete
                    <span class="font-medium text-text">
                        {{ $post->title }}
                    </span>?
                </p>

                <p class="mt-2 text-sm leading-6 text-text-muted">
                    This action cannot be undone.
                </p>

                <div class="mt-6 flex justify-end gap-3">

                    <button
                        type="button"
                        id="cancel-delete"
                        class="rounded-md border border-border px-4 py-2 text-sm font-medium text-text hover:bg-surface"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        id="confirm-delete"
                        class="rounded-md bg-error px-4 py-2 text-sm font-medium text-white hover:bg-error/90"
                    >
                        Delete Post
                    </button>

                </div>

            </div>
        </div>

    @endcan
@endauth


{{-- Delete modal script --}}
@auth
    @can('delete', $post)

        <script>
            const deleteButton = document.getElementById('delete-post-button');
            const deleteModal = document.getElementById('delete-post-modal');
            const cancelDelete = document.getElementById('cancel-delete');
            const confirmDelete = document.getElementById('confirm-delete');
            const deleteForm = document.getElementById('delete-post-form');

            deleteButton?.addEventListener('click', () => {
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
            });

            cancelDelete?.addEventListener('click', () => {
                closeDeleteModal();
            });

            confirmDelete?.addEventListener('click', () => {
                deleteForm.submit();
            });

            deleteModal?.addEventListener('click', (event) => {
                if (event.target === deleteModal) {
                    closeDeleteModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeDeleteModal();
                }
            });

            function closeDeleteModal() {
                deleteModal.classList.remove('flex');
                deleteModal.classList.add('hidden');
            }
        </script>

    @endcan
@endauth

@endsection
