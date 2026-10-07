@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Posts')

@section('content')

{{-- Header --}}
<section class="border-b border-border">
    <div class="flex flex-col gap-4 mx-auto w-full max-w-300 px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-12">

        <p class="text-sm font-medium uppercase tracking-wide text-primary">
            Research and activities
        </p>

        <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">
            Posts
        </h1>

        <p class="max-w-2xl text-base leading-7 text-text-muted">
            Research updates, field activities, institutional information, and announcements.
        </p>

        @auth
            @can('create', App\Models\Post::class)
                <a
                    href="{{ route('dashboard.posts.create') }}"
                    class="inline-flex shrink-0 w-max items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                >
                    Add Post
                </a>
            @endcan
        @endauth

    </div>
</section>


{{-- Posts --}}
<section>
    <div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-8 sm:py-12">

        @if ($posts->isNotEmpty())

            <div class="divide-y divide-border border-y border-border py-8">

                @foreach ($posts as $post)

                    <article class="py-6 first:pt-0 last:pb-0">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                            <div class="min-w-0">

                                <h2 class="text-lg font-semibold leading-7 text-text">
                                    <a
                                        href="{{ route('posts.show', $post->slug) }}"
                                        class="hover:text-primary"
                                    >
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-text-muted">

                                    @if ($post->published_at)
                                        <span>
                                            {{ $post->published_at->format('d M Y') }}
                                        </span>
                                    @endif

                                    @if ($post->category)
                                        <span>
                                            {{ str_replace('_', ' ', ucfirst($post->category)) }}
                                        </span>
                                    @endif

                                    @if ($post->author)
                                        <span>
                                            {{ $post->author->name }}
                                        </span>
                                    @endif

                                </div>

                                @if ($post->excerpt)
                                    <p class="mt-3 line-clamp-2 text-sm leading-6 text-text-muted">
                                        {{ $post->excerpt }}
                                    </p>
                                @endif

                            </div>

                            <a
                                href="{{ route('posts.show', $post->slug) }}"
                                class="shrink-0 text-sm font-medium text-primary hover:text-primary-hover"
                            >
                                View
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- Pagination --}}
            @if ($posts->hasPages())
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @endif

        @else

            {{-- Empty state --}}
            <div class="border-y border-border py-16 text-center">

                <h2 class="text-lg font-semibold text-text">
                    No posts found
                </h2>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-text-muted">
                    There are no posts available yet.
                </p>

                @auth
                    @can('create', App\Models\Post::class)
                        <a
                            href="{{ route('dashboard.posts.create') }}"
                            class="mt-6 inline-flex rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
                        >
                            Add Post
                        </a>
                    @endcan
                @endauth

            </div>

        @endif

    </div>
</section>

@endsection
