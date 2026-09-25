@csrf

<div class="space-y-10">

    {{-- Basic information --}}
    <section>
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Basic information
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                Basic information about the teaching material.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6">

            {{-- Title --}}
            <div>
                <label
                    for="title"
                    class="block text-sm font-medium text-text"
                >
                    Title
                </label>

                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $teachingMaterial->title ?? '') }}"
                    autofocus
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('title')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label
                    for="description"
                    class="block text-sm font-medium text-text"
                >
                    Description
                </label>

                <textarea
                    name="description"
                    id="description"
                    rows="6"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm leading-6 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >{{ old('description', $teachingMaterial->description ?? '') }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </section>


    {{-- Presentation --}}
    <section class="border-t border-border pt-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Presentation
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                Provide the Google Drive link to the presentation file.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6">

            {{-- PPT URL --}}
            <div>
                <label
                    for="ppt_url"
                    class="block text-sm font-medium text-text"
                >
                    Presentation URL
                </label>

                <input
                    type="url"
                    name="ppt_url"
                    id="ppt_url"
                    value="{{ old('ppt_url', $teachingMaterial->ppt_url ?? '') }}"
                    placeholder="https://drive.google.com/..."
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                <p class="mt-1 text-sm text-text-muted">
                    Use a Google Drive URL that can be accessed by authorized users.
                </p>

                @error('ppt_url')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </section>


    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3 border-t border-border pt-8">

        <a
            href="{{route('dashboard.teaching-materials.index') }}"
            class="rounded-md border border-border-strong px-4 py-2 text-sm font-medium text-text hover:bg-background"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
        >
            {{ isset($teachingMaterial)
                ? 'Update Teaching Material'
                : 'Create Teaching Material' }}
        </button>

    </div>

</div>
