@csrf

@if ($errors->any())
    <div class="mb-6 rounded-md border border-error bg-error-light p-4">
        <h2 class="text-sm font-medium text-error">
            Please correct the following errors:
        </h2>

        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">

    {{-- Title --}}
    <div>
        <label
            for="title"
            class="block text-sm font-medium text-text"
        >
            Title
        </label>

        <input
            id="title"
            name="title"
            type="text"
            value="{{ old('title', $post?->title ?? '') }}"
            autofocus
            required
            class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text outline-none placeholder:text-text-muted focus:border-primary focus:ring-1 focus:ring-primary"
        >

        @error('title')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Excerpt --}}
    <div>
        <label
            for="excerpt"
            class="block text-sm font-medium text-text"
        >
            Excerpt
        </label>

        <textarea
            id="excerpt"
            name="excerpt"
            rows="3"
            class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm leading-6 text-text outline-none placeholder:text-text-muted focus:border-primary focus:ring-1 focus:ring-primary"
        >{{ old('excerpt', $post?->excerpt ?? '') }}</textarea>

        @error('excerpt')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Content --}}
    <div>
        <label
            for="content"
            class="block text-sm font-medium text-text"
        >
            Content
        </label>

        <textarea
            id="content"
            name="content"
            rows="16"
            required
            class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm leading-7 text-text outline-none placeholder:text-text-muted focus:border-primary focus:ring-1 focus:ring-primary"
        >{{ old('content', $post?->content ?? '') }}</textarea>

        @error('content')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Category --}}
    <div>
        <label
            for="category"
            class="block text-sm font-medium text-text"
        >
            Category
        </label>

        <select
            id="category"
            name="category"
            required
            class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text outline-none focus:border-primary focus:ring-1 focus:ring-primary"
        >
            <option value="">Select category</option>

            <option
                value="research_update"
                @selected(old('category', $post?->category ?? '') === 'research_update')
            >
                Research Update
            </option>

            <option
                value="publication"
                @selected(old('category', $post?->category ?? '') === 'publication')
            >
                Publication
            </option>

            <option
                value="field_activity"
                @selected(old('category', $post?->category ?? '') === 'field_activity')
            >
                Field Activity
            </option>

            <option
                value="institutional"
                @selected(old('category', $post?->category ?? '') === 'institutional')
            >
                Institutional
            </option>

            <option
                value="announcement"
                @selected(old('category', $post?->category ?? '') === 'announcement')
            >
                Announcement
            </option>
        </select>

        @error('category')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Featured Image --}}
    <div>
        <label
            for="featured_image"
            class="block text-sm font-medium text-text"
        >
            Featured Image
        </label>

        <p class="mt-1 text-sm text-text-muted">
            Optional. Maximum file size: 5 MB.
        </p>

        <input
            id="featured_image"
            name="featured_image"
            type="file"
            accept="image/*"
            class="mt-3 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text file:mr-4 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-primary-hover"
        >

        @error('featured_image')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror

        @if ($post?->featured_image_url)
            <div class="mt-4">
                <p class="mb-2 text-xs font-medium uppercase tracking-wide text-text-muted">
                    Current image
                </p>

                <div class="overflow-hidden rounded-md border border-border">
                    <img
                        src="{{ $post->featured_image_url }}"
                        alt="{{ $post->title }}"
                        class="aspect-video w-full object-cover sm:max-w-xl"
                    >
                </div>
            </div>
        @endif
    </div>

    {{-- Research Project --}}
    <div>
        <label
            for="research_project_id"
            class="block text-sm font-medium text-text"
        >
            Research Project
        </label>

        <select
            id="research_project_id"
            name="research_project_id"
            class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text outline-none focus:border-primary focus:ring-1 focus:ring-primary"
        >
            <option value="">None</option>

            @foreach ($researchProjects as $researchProject)
                <option
                    value="{{ $researchProject->id }}"
                    @selected(
                        (string) old(
                            'research_project_id',
                            $post?->research_project_id ?? ''
                        ) === (string) $researchProject->id
                    )
                >
                    {{ $researchProject->title }}
                </option>
            @endforeach
        </select>

        @error('research_project_id')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label
            for="status"
            class="block text-sm font-medium text-text"
        >
            Status
        </label>

        <select
            id="status"
            name="status"
            required
            class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text outline-none focus:border-primary focus:ring-1 focus:ring-primary"
        >
            <option
                value="draft"
                @selected(old('status', $post?->status ?? 'draft') === 'draft')
            >
                Draft
            </option>

            <option
                value="published"
                @selected(old('status', $post?->status ?? '') === 'published')
            >
                Published
            </option>

            <option
                value="archived"
                @selected(old('status', $post?->status ?? '') === 'archived')
            >
                Archived
            </option>
        </select>

        @error('status')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Published At --}}
    <div>
        <label
            for="published_at"
            class="block text-sm font-medium text-text"
        >
            Published At
        </label>

        <input
            id="published_at"
            name="published_at"
            type="datetime-local"
            value="{{ old(
                'published_at',
                $post?->published_at?->format('Y-m-d\TH:i') ?? ''
            ) }}"
            class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text outline-none focus:border-primary focus:ring-1 focus:ring-primary"
        >

        @error('published_at')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror

        <p class="mt-1 text-xs leading-5 text-text-muted">
            Leave empty to automatically set the publication date when the post is published.
        </p>
    </div>

</div>

{{-- Actions --}}
<div class="mt-8 flex items-center justify-end gap-3 border-t border-border pt-6">

    <a
        href="{{ route('dashboard.posts.index') }}"
        class="rounded-md border border-border px-4 py-2 text-sm font-medium text-text hover:bg-background"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
    >
        {{ isset($post) ? 'Update Post' : 'Create Post' }}
    </button>

</div>
