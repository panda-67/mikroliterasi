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

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

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

    {{-- Authors --}}
    <section class="border-t border-border pt-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Authors
            </h2>

            <p class="mt-1 text-sm text-text-muted">
                Add authors in their publication order.
            </p>
        </div>

        @php
            $selectedPeople = old('people');

            if ($selectedPeople === null) {
                $selectedPeople = isset($publication)
                    ? $publication->people
                        ->sortBy('pivot.author_order')
                        ->values()
                        ->map(fn ($person) => [
                            'person_id' => $person->id,
                            'author_order' => $person->pivot->author_order,
                        ])
                        ->toArray()
                    : [];
            }
        @endphp

        <div
            id="authors-container"
            class="space-y-3"
        >

            @foreach ($selectedPeople as $index => $selectedPerson)

                <div
                    class="author-row flex items-end gap-3"
                >

                    {{-- Order --}}
                    <div class="w-12 shrink-0">
                        <label class="block text-sm font-medium text-text">
                            No.
                        </label>

                        <div
                            class="author-order mt-2 flex h-10 items-center justify-center rounded-md border border-border bg-background text-sm text-text"
                        >
                            {{ $index + 1 }}
                        </div>

                        <input
                            type="hidden"
                            name="people[{{ $index }}][author_order]"
                            value="{{ $selectedPerson['author_order'] ?? ($index + 1) }}"
                            class="author-order-input"
                        >
                    </div>

                    {{-- Person --}}
                    <div class="min-w-0 flex-1">
                        <label
                            for="people_{{ $index }}_person_id"
                            class="block text-sm font-medium text-text"
                        >
                            Person
                        </label>

                        <select
                            name="people[{{ $index }}][person_id]"
                            id="people_{{ $index }}_person_id"
                            class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        >
                            <option value="">
                                Select person
                            </option>

                            @foreach ($people as $person)
                                <option
                                    value="{{ $person->id }}"
                                    @selected(
                                        (string) ($selectedPerson['person_id'] ?? '') ===
                                        (string) $person->id
                                    )
                                >
                                    {{ $person->name }}
                                </option>
                            @endforeach
                        </select>

                        @error("people.$index.person_id")
                            <p class="mt-1 text-sm text-error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remove --}}
                    <button
                        type="button"
                        class="remove-author shrink-0 rounded-md border border-border-strong px-3 py-2 text-sm font-medium text-text hover:bg-background"
                    >
                        Remove
                    </button>

                </div>

            @endforeach

        </div>

        <div class="mt-4">
            <button
                type="button"
                id="add-author"
                class="rounded-md border border-border-strong px-4 py-2 text-sm font-medium text-text hover:bg-background"
            >
                Add Author
            </button>
        </div>

        <template id="author-row-template">

            <div class="author-row flex items-end gap-3">

                {{-- Order --}}
                <div class="w-12 shrink-0">
                    <label class="block text-sm font-medium text-text">
                        No.
                    </label>

                    <div
                        class="author-order mt-2 flex h-10 items-center justify-center rounded-md border border-border bg-background text-sm text-text"
                    >
                        __ORDER__
                    </div>

                    <input
                        type="hidden"
                        name="people[__INDEX__][author_order]"
                        value="__ORDER__"
                        class="author-order-input"
                    >
                </div>

                {{-- Person --}}
                <div class="min-w-0 flex-1">
                    <label
                        for="people___INDEX___person_id"
                        class="block text-sm font-medium text-text"
                    >
                        Person
                    </label>

                    <select
                        name="people[__INDEX__][person_id]"
                        id="people___INDEX___person_id"
                        class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                    >
                        <option value="">
                            Select person
                        </option>

                        @foreach ($people as $person)
                            <option value="{{ $person->id }}">
                                {{ $person->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Remove --}}
                <button
                    type="button"
                    class="remove-author shrink-0 rounded-md border border-border-strong px-3 py-2 text-sm font-medium text-text hover:bg-background"
                >
                    Remove
                </button>

            </div>

        </template>
    </section>

    {{-- Research projects --}}
    <section class="border-t border-border pt-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Research projects
            </h2>

            <p class="mt-1 text-sm text-text-muted">
                Select the research projects related to this publication.
            </p>
        </div>

        @php
            $selectedResearchProjects = old('research_projects');

            if ($selectedResearchProjects === null) {
                $selectedResearchProjects = isset($publication)
                    ? $publication->researchProjects
                        ->pluck('id')
                        ->map(fn ($id) => (string) $id)
                        ->toArray()
                    : [];
            }

            $selectedResearchProjects = array_map(
                'strval',
                $selectedResearchProjects
            );
        @endphp

        @if ($researchProjects->isNotEmpty())

            <div class="divide-y divide-border border-y border-border">

                @foreach ($researchProjects as $researchProject)

                    <label
                        for="research_project_{{ $researchProject->id }}"
                        class="flex cursor-pointer items-start gap-3 py-4"
                    >

                        <input
                            type="checkbox"
                            name="research_projects[]"
                            value="{{ $researchProject->id }}"
                            id="research_project_{{ $researchProject->id }}"
                            @checked(
                                in_array(
                                    (string) $researchProject->id,
                                    $selectedResearchProjects,
                                    true
                                )
                            )
                            class="mt-0.5 h-4 w-4 rounded border-border text-primary focus:ring-primary"
                        >

                        <span class="min-w-0">
                            <span class="block text-sm font-medium text-text">
                                {{ $researchProject->title }}
                            </span>

                            @if ($researchProject->short_description)
                                <span class="mt-1 block text-sm leading-6 text-text-muted">
                                    {{ $researchProject->short_description }}
                                </span>
                            @endif
                        </span>

                    </label>

                @endforeach

            </div>

        @else

            <div class="border-y border-border py-6">
                <p class="text-sm text-text-muted">
                    No research projects are available yet.
                </p>
            </div>

        @endif

        @error('research_projects')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror

        @error('research_projects.*')
            <p class="mt-2 text-sm text-error">
                {{ $message }}
            </p>
        @enderror
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

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

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

    <input
        type="hidden"
        name="fromDashboard"
        value="{{ $fromDashboard ? '1' : '0' }}"
    >
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById(
            'authors-container'
        );

        const addButton = document.getElementById(
            'add-author'
        );

        const template = document.getElementById(
            'author-row-template'
        );

        if (!container || !addButton || !template) {
            return;
        }

        let index = {{ count($selectedPeople) }};

        function updateAuthorOrder() {
            const rows = container.querySelectorAll(
                '.author-row'
            );

            rows.forEach(function (row, position) {
                const order = position + 1;

                row.querySelector('.author-order').textContent =
                    order;

                row.querySelector('.author-order-input').value =
                    order;
            });
        }

        addButton.addEventListener('click', function () {
            const html = template.innerHTML
                .replaceAll('__INDEX__', index)
                .replaceAll('__ORDER__', index + 1);

            container.insertAdjacentHTML(
                'beforeend',
                html
            );

            index++;

            updateAuthorOrder();
        });

        container.addEventListener('click', function (event) {
            const button = event.target.closest(
                '.remove-author'
            );

            if (!button) {
                return;
            }

            const rows = container.querySelectorAll(
                '.author-row'
            );

            if (rows.length === 1) {
                const row = button.closest('.author-row');

                row.querySelector('select').value = '';
                row.querySelector('.author-order-input').value = '';

                return;
            }

            button.closest('.author-row').remove();

            updateAuthorOrder();
        });
    });
</script>
