@csrf

<div class="space-y-5">

    {{-- Name --}}
    <div>
        <label
            for="{{ $nameInputId }}"
            class="block text-sm font-medium text-text"
        >
            Name
        </label>

        <input
            id="{{ $nameInputId }}"
            name="name"
            type="text"
            value="{{ $isActiveModal
                ? old('name', $researchArea?->name ?? '')
                : ($researchArea?->name ?? '') }}"
            autofocus
            class="mt-2 block w-full border border-border bg-background px-3 py-2.5 text-sm text-text outline-none transition focus:border-text"
        >

        @if ($isActiveModal)
            @error('name')
                <p class="mt-2 text-sm text-error">
                    {{ $message }}
                </p>
            @enderror
        @endif
    </div>

    {{-- Description --}}
    <div>
        <label
            for="{{ $descriptionInputId }}"
            class="block text-sm font-medium text-text"
        >
            Description
        </label>

        <textarea
            id="{{ $descriptionInputId }}"
            name="description"
            rows="4"
            class="mt-2 block w-full resize-y border border-border bg-background px-3 py-2.5 text-sm leading-6 text-text outline-none transition focus:border-text"
        >{{ $isActiveModal
            ? old('description', $researchArea?->description ?? '')
            : ($researchArea?->description ?? '') }}</textarea>

        @if ($isActiveModal)
            @error('description')
                <p class="mt-2 text-sm text-error">
                    {{ $message }}
                </p>
            @enderror
        @endif
    </div>

</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-border pt-6 sm:flex-row sm:justify-end">

    <button
        type="button"
        onclick="document.getElementById('{{ $modalId }}').close()"
        class="inline-flex items-center justify-center rounded-md border border-border px-4 py-2.5 text-sm font-medium text-text transition hover:bg-background"
    >
        Cancel
    </button>

    <button
        type="submit"
        class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
    >
        {{ $submitLabel }}
    </button>

</div>
