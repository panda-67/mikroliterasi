@php
    $publicationTypes = [
        'journal_article' => 'Journal Article',
        'conference_paper' => 'Conference Paper',
        'book' => 'Book',
        'book_chapter' => 'Book Chapter',
        'technical_report' => 'Technical Report',
        'policy_brief' => 'Policy Brief',
        'thesis' => 'Thesis',
        'dataset' => 'Dataset',
        'other' => 'Other',
    ];
@endphp

<div class="space-y-10">

    {{-- Publication details --}}
    <section>
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Publication details
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                Basic information about the publication.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 pb-12">

            {{-- Title --}}
            <div class="md:col-span-2">
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
                    value="{{ old('title', $publication->title ?? '') }}"
                    required
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('title')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Publication type --}}
            <div>
                <label
                    for="publication_type"
                    class="block text-sm font-medium text-text"
                >
                    Publication type
                </label>

                <select
                    name="publication_type"
                    id="publication_type"
                    required
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >
                    <option value="">Select type</option>

                    @foreach ($publicationTypes as $value => $label)
                        <option
                            value="{{ $value }}"
                            @selected(
                                old(
                                    'publication_type',
                                    $publication->publication_type ?? ''
                                ) === $value
                            )
                        >
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                @error('publication_type')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Year --}}
            <div>
                <label
                    for="year"
                    class="block text-sm font-medium text-text"
                >
                    Year
                </label>

                <input
                    type="number"
                    name="year"
                    id="year"
                    value="{{ old('year', $publication->year ?? '') }}"
                    min="1900"
                    max="{{ now()->year + 1 }}"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('year')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Journal --}}
            <div>
                <label
                    for="journal"
                    class="block text-sm font-medium text-text"
                >
                    Journal
                </label>

                <input
                    type="text"
                    name="journal"
                    id="journal"
                    value="{{ old('journal', $publication->journal ?? '') }}"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('journal')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Publisher --}}
            <div>
                <label
                    for="publisher"
                    class="block text-sm font-medium text-text"
                >
                    Publisher
                </label>

                <input
                    type="text"
                    name="publisher"
                    id="publisher"
                    value="{{ old('publisher', $publication->publisher ?? '') }}"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('publisher')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Volume --}}
            <div>
                <label
                    for="volume"
                    class="block text-sm font-medium text-text"
                >
                    Volume
                </label>

                <input
                    type="text"
                    name="volume"
                    id="volume"
                    value="{{ old('volume', $publication->volume ?? '') }}"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('volume')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Issue --}}
            <div>
                <label
                    for="issue"
                    class="block text-sm font-medium text-text"
                >
                    Issue
                </label>

                <input
                    type="text"
                    name="issue"
                    id="issue"
                    value="{{ old('issue', $publication->issue ?? '') }}"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('issue')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Pages --}}
            <div>
                <label
                    for="pages"
                    class="block text-sm font-medium text-text"
                >
                    Pages
                </label>

                <input
                    type="text"
                    name="pages"
                    id="pages"
                    value="{{ old('pages', $publication->pages ?? '') }}"
                    placeholder="e.g. 101–115"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('pages')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </section>


    {{-- Identifiers and links --}}
    <section class="border-t border-border pt-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Identifiers and links
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                Persistent identifiers and external publication links.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 pb-12">

            {{-- DOI --}}
            <div>
                <label
                    for="doi"
                    class="block text-sm font-medium text-text"
                >
                    DOI
                </label>

                <input
                    type="text"
                    name="doi"
                    id="doi"
                    value="{{ old('doi', $publication->doi ?? '') }}"
                    placeholder="10.xxxx/xxxxx"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('doi')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- URL --}}
            <div>
                <label
                    for="url"
                    class="block text-sm font-medium text-text"
                >
                    External URL
                </label>

                <input
                    type="url"
                    name="url"
                    id="url"
                    value="{{ old('url', $publication->url ?? '') }}"
                    placeholder="https://..."
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('url')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </section>


    {{-- Abstract --}}
    <section class="border-t border-border pt-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Abstract
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                Abstract or summary of the publication.
            </p>
        </div>

        <div>
            <label
                for="abstract"
                class="block text-sm font-medium text-text"
            >
                Abstract
            </label>

            <textarea
                name="abstract"
                id="abstract"
                rows="8"
                class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm leading-6 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
            >{{ old('abstract', $publication->abstract ?? '') }}</textarea>

            @error('abstract')
                <p class="mt-1 text-sm text-error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </section>

</div>
