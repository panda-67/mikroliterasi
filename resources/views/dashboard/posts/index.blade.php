@extends('layouts.dashboard')

@section('title', 'Posts | Dashboard | ' . config('app.name', 'Mikroliterasi'))

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

            <span class="text-text">
                Posts
            </span>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-text sm:text-3xl">
                    Posts
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-text-muted">
                    Manage research updates, field activities, institutional information, and announcements.
                </p>
            </div>

            @can('create', App\Models\Post::class)
                <a
                    href="{{ route('dashboard.posts.create') }}"
                    class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                >
                    New Post
                </a>
            @endcan

        </div>

    </div>

    {{-- Posts --}}
    @if ($posts->isNotEmpty())

        <div class="overflow-hidden rounded-lg border border-border bg-surface">

            <div class="overflow-x-auto">

                <table class="w-full min-w-180 text-left">

                    <thead class="border-b border-border bg-background">
                        <tr>
                            <th class="px-5 py-3 text-xs font-medium uppercase tracking-wide text-text-muted">
                                Post
                            </th>

                            <th class="px-5 py-3 text-xs font-medium uppercase tracking-wide text-text-muted">
                                Category
                            </th>

                            <th class="px-5 py-3 text-xs font-medium uppercase tracking-wide text-text-muted">
                                Status
                            </th>

                            <th class="px-5 py-3 text-xs font-medium uppercase tracking-wide text-text-muted">
                                Published
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-medium uppercase tracking-wide text-text-muted">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border">

                        @foreach ($posts as $post)

                            <tr class="align-top">

                                {{-- Post --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-start gap-4">

                                        @if ($post->featured_image_url)
                                            <div class="hidden h-16 w-24 shrink-0 overflow-hidden rounded-md border border-border sm:block">
                                                <img
                                                    src="{{ $post->featured_image_url }}"
                                                    alt="{{ $post->title }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            </div>
                                        @endif

                                        <div class="min-w-0">

                                            <a
                                                href="{{ $post->status === 'published'
                                                    ? route('posts.show', $post)
                                                    : route('dashboard.posts.edit', $post) }}"
                                                class="font-medium text-text hover:text-primary"
                                            >
                                                {{ $post->title }}
                                            </a>

                                            @if ($post->excerpt)
                                                <p class="mt-1 line-clamp-2 max-w-2xl text-sm leading-6 text-text-muted">
                                                    {{ $post->excerpt }}
                                                </p>
                                            @endif

                                            @if ($post->author)
                                                <p class="mt-2 text-xs text-text-subtle">
                                                    {{ $post->author->name }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>

                                {{-- Category --}}
                                <td class="px-5 py-4">

                                    <span class="text-sm text-text">
                                        {{ str_replace('_', ' ', ucfirst($post->category)) }}
                                    </span>

                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($post->status === 'published')

                                        <span class="inline-flex rounded-full border border-success px-2.5 py-1 text-xs font-medium text-success">
                                            Published
                                        </span>

                                    @elseif ($post->status === 'draft')

                                        <span class="inline-flex rounded-full border border-border px-2.5 py-1 text-xs font-medium text-text-muted">
                                            Draft
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full border border-border px-2.5 py-1 text-xs font-medium text-text-muted">
                                            Archived
                                        </span>

                                    @endif

                                </td>

                                {{-- Published --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-text-muted">

                                    @if ($post->published_at)
                                        {{ $post->published_at->format('d M Y') }}
                                    @else
                                        —
                                    @endif

                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-end gap-3">

                                        @if ($post->status === 'published')
                                            <a
                                                href="{{ route('posts.show', $post) }}"
                                                class="text-sm font-medium text-primary hover:text-primary-hover"
                                            >
                                                View
                                            </a>
                                        @endif

                                        @can('update', $post)
                                            <a
                                                href="{{ route('dashboard.posts.edit', $post) }}"
                                                class="text-sm font-medium text-primary hover:text-primary-hover"
                                            >
                                                Edit
                                            </a>
                                        @endcan

                                        {{-- Delete --}}
                                        @can('delete', $post)

                                            <button
                                                type="button"
                                                onclick="document.getElementById('delete-post-{{ $post->id }}').showModal()"
                                                class="text-sm font-medium text-error hover:opacity-80"
                                            >
                                                Delete
                                            </button>

                                            {{-- Modal Delete --}}
                                            <dialog
                                                id="delete-post-{{ $post->id }}"
                                                class="m-auto w-full max-w-md rounded-lg border border-border bg-surface p-0 shadow-xl backdrop:bg-black/40"
                                            >
                                                <div class="p-6">

                                                    <div class="mb-5">

                                                        <h2 class="text-lg font-semibold text-text">
                                                            Delete Post
                                                        </h2>

                                                        <p class="mt-2 text-sm leading-6 text-text-muted">
                                                            Are you sure you want to delete
                                                            <span class="font-medium text-text">
                                                                {{ $post->title }}
                                                            </span>?
                                                            This action cannot be undone.
                                                        </p>

                                                    </div>

                                                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                                                        <button
                                                            type="button"
                                                            onclick="document.getElementById('delete-post-{{ $post->id }}').close()"
                                                            class="inline-flex items-center justify-center rounded-md border border-border px-4 py-2.5 text-sm font-medium text-text transition hover:bg-card"
                                                        >
                                                            Cancel
                                                        </button>

                                                        <form
                                                            method="POST"
                                                            action="{{ route('dashboard.posts.destroy', $post) }}"
                                                        >
                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="inline-flex w-full items-center justify-center rounded-md bg-error px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90 sm:w-auto"
                                                            >
                                                                Delete Post
                                                            </button>

                                                        </form>

                                                    </div>

                                                </div>
                                            </dialog>

                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        @if ($posts->hasPages())
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif

    @else

        {{-- Empty state --}}
        <div class="rounded-lg border border-border bg-surface px-6 py-16 text-center">

            <h2 class="text-lg font-semibold text-text">
                No posts found
            </h2>

            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-text-muted">
                There are no posts available in the dashboard yet.
            </p>

            @can('create', App\Models\Post::class)
                <a
                    href="{{ route('dashboard.posts.create') }}"
                    class="mt-6 inline-flex rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                >
                    Add Post
                </a>
            @endcan

        </div>

    @endif

</div>

@endsection
