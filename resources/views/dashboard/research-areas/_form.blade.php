@csrf

<div class="space-y-6">

{{-- Name --}}
<div>
    <label
        for="name"
        class="block text-sm font-medium text-text"
    >
        Name
    </label>

    <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', $researchArea->name ?? '') }}"
        autofocus
        class="mt-2 block w-full border border-border bg-background px-3 py-2.5 text-sm text-text outline-none transition focus:border-text"
    >

    @error('name')
        <p class="mt-2 text-sm text-red-700">
            {{ $message }}
        </p>
    @enderror
</div>

{{-- Slug --}}
<div>
    <label
        for="slug"
        class="block text-sm font-medium text-text"
    >
        Slug
    </label>

    <input
        id="slug"
        name="slug"
        type="text"
        value="{{ old('slug', $researchArea->slug ?? '') }}"
        class="mt-2 block w-full border border-border bg-background px-3 py-2.5 text-sm text-text outline-none transition focus:border-text"
    >

    <p class="mt-2 text-xs leading-5 text-text-muted">
        Used as the internal identifier for this research area.
    </p>

    @error('slug')
        <p class="mt-2 text-sm text-red-700">
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
        id="description"
        name="description"
        rows="5"
        class="mt-2 block w-full resize-y border border-border bg-background px-3 py-2.5 text-sm leading-6 text-text outline-none transition focus:border-text"
    >{{ old('description', $researchArea->description ?? '') }}</textarea>

    @error('description')
        <p class="mt-2 text-sm text-red-700">
            {{ $message }}
        </p>
    @enderror
</div>

</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-border pt-6 sm:flex-row sm:justify-end">

<a
    href="{{ route('dashboard.research-areas.index') }}"
    class="inline-flex items-center justify-center border border-border px-4 py-2.5 text-sm font-medium text-text transition hover:bg-background"
>
    Cancel
</a>

<button
    type="submit"
    class="inline-flex items-center justify-center border border-text bg-text px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
>
    {{ $submitLabel }}
</button>

</div>
