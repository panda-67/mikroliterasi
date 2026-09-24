@php
    $selectedPublications = old('publications');

    if ($selectedPublications === null) {
        $selectedPublications = isset($project)
            ? $project->publications
                ->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->toArray()
            : [];
    }

    $selectedPublications = array_map(
        'strval',
        $selectedPublications
    );
@endphp

<div class="space-y-6">

    {{-- Title --}}
    <div>
        <label
            for="title"
            class="mb-2 block text-sm font-medium text-text"
        >
            Title
        </label>

        <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $project->title ?? '') }}"
            class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text placeholder:text-text-subtle focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
        >

        @error('title')
            <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Short Description --}}
    <div>
        <label
            for="short_description"
            class="mb-2 block text-sm font-medium text-text"
        >
            Short Description
        </label>

        <textarea
            id="short_description"
            name="short_description"
            rows="3"
            class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text placeholder:text-text-subtle focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
        >{{ old('short_description', $project->short_description ?? '') }}</textarea>

        @error('short_description')
            <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label
            for="description"
            class="mb-2 block text-sm font-medium text-text"
        >
            Description
        </label>

        <textarea
            id="description"
            name="description"
            rows="8"
            class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text placeholder:text-text-subtle focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
        >{{ old('description', $project->description ?? '') }}</textarea>

        @error('description')
            <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Research Areas --}}
    <div class="space-y-4">
        <div>
            <h2 class="text-sm font-semibold text-text">
                Research Areas
            </h2>

            <p class="mt-1 text-xs text-text-muted">
                Pilih bidang penelitian yang terkait dengan research project ini.
            </p>
        </div>

        @php
            $selectedResearchAreas = old('research_areas');

            if ($selectedResearchAreas === null) {
                $selectedResearchAreas = isset($project)
                    ? $project->researchAreas
                        ->pluck('id')
                        ->map(fn ($id) => (string) $id)
                        ->toArray()
                    : [];
            }

            $selectedResearchAreas = array_map(
                'strval',
                $selectedResearchAreas
            );
        @endphp

        @if ($researchAreas->isEmpty())
            <div class="rounded-lg border border-border bg-surface px-4 py-3">
                <p class="text-xs text-text-muted">
                    Belum ada research area yang tersedia.
                </p>
            </div>
        @else
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($researchAreas as $researchArea)
                    <label
                        for="research-area-{{ $researchArea->id }}"
                        class="flex cursor-pointer items-start gap-3 rounded-lg border border-border p-4 transition hover:bg-surface"
                    >
                        <input
                            type="checkbox"
                            id="research-area-{{ $researchArea->id }}"
                            name="research_areas[]"
                            value="{{ $researchArea->id }}"
                            @checked(in_array(
                                (string) $researchArea->id,
                                $selectedResearchAreas,
                                true
                            ))
                            class="mt-0.5 rounded border-border"
                        >

                        <span>
                            <span class="block text-sm font-medium text-text">
                                {{ $researchArea->name }}
                            </span>

                            @if ($researchArea->description)
                                <span class="mt-1 block text-xs text-text-muted">
                                    {{ $researchArea->description }}
                                </span>
                            @endif
                        </span>
                    </label>
                @endforeach
            </div>
        @endif

        @error('research_areas')
            <p class="text-xs text-red-600">
                {{ $message }}
            </p>
        @enderror

        @error('research_areas.*')
            <p class="text-xs text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Publications --}}
    <div class="space-y-4">
       <div>
            <h2 class="text-sm font-semibold text-text">
                Publications
            </h2>

            <p class="mt-1 text-xs text-text-muted">
                Pilih publikasi yang terkait dengan research project ini.
            </p>
        </div>


        @if ($publications->isEmpty())
            <p class="text-sm text-gray-500">
                Belum ada publication yang tersedia.
            </p>
        @else
            <div class="space-y-3">
                @foreach ($publications as $publication)
                    <label
                        class="flex items-start gap-3 rounded-lg border border-gray-200 bg-[#edecea] p-4 cursor-pointer hover:bg-gray-100"
                    >
                        <input
                            type="checkbox"
                            name="publications[]"
                            value="{{ $publication->id }}"
                            @checked(
                                in_array(
                                    (string) $publication->id,
                                    $selectedPublications,
                                    true
                                )
                            )
                            class="mt-1 rounded border-gray-300 text-gray-800 focus:ring-gray-500"
                        >

                        <span class="min-w-0">
                            <span class="block text-sm font-medium text-gray-900">
                                {{ $publication->title }}
                            </span>

                            <span class="mt-1 block text-xs text-gray-500">
                                {{ $publication->year ?? 'Tahun tidak tersedia' }}
                                ·
                                {{ str_replace('_', ' ', ucfirst($publication->publication_type)) }}
                            </span>
                        </span>
                    </label>
                @endforeach
            </div>
        @endif

        @error('publications')
            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

        @error('publications.*')
            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Research Team --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-sm font-semibold text-text">
                    Research Team
                </h2>

                <p class="mt-1 text-xs text-text-muted">
                    Assign researchers and define their roles in this project.
                </p>
            </div>

            <button
                type="button"
                id="add-person"
                class="rounded-md border border-border px-3 py-2 text-xs font-medium text-text transition hover:bg-surface"
            >
                + Add Person
            </button>
        </div>

        <div
            id="people-container"
            class="space-y-3"
        >
            @php
                $selectedPeople = old('people');

                if ($selectedPeople === null) {
                    $selectedPeople = isset($project)
                        ? $project->people->map(fn ($person) => [
                            'person_id' => $person->id,
                            'role' => $person->pivot->role,
                        ])->values()->toArray()
                        : [];
                }

                if (empty($selectedPeople)) {
                    $selectedPeople = [
                        [
                            'person_id' => '',
                            'role' => '',
                        ],
                    ];
                }
            @endphp

            @foreach ($selectedPeople as $index => $selectedPerson)
                <div class="person-row grid gap-3 rounded-lg border border-border p-4 md:grid-cols-[1fr_1fr_auto]">
                    <div>
                        <label
                            for="person-{{ $index }}"
                            class="mb-1 block text-xs font-medium text-text"
                        >
                            Person
                        </label>

                        <select
                            id="person-{{ $index }}"
                            name="people[{{ $index }}][person_id]"
                            class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text"
                        >
                            <option value="">Select person</option>

                            @foreach ($people as $person)
                                <option
                                    value="{{ $person->id }}"
                                    @selected((string) ($selectedPerson['person_id'] ?? '') === (string) $person->id)
                                >
                                    {{ $person->name }}
                                </option>
                            @endforeach
                        </select>

                        @error("people.$index.person_id")
                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="person-role-{{ $index }}"
                            class="mb-1 block text-xs font-medium text-text"
                        >
                            Role
                        </label>

                        <input
                            type="text"
                            id="person-role-{{ $index }}"
                            name="people[{{ $index }}][role]"
                            value="{{ $selectedPerson['role'] ?? '' }}"
                            placeholder="e.g. Principal Investigator"
                            class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text"
                        >

                        @error("people.$index.role")
                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-end">
                        <button
                            type="button"
                            class="remove-person w-full rounded-md border border-border px-3 py-2 text-xs font-medium text-text-muted transition hover:bg-surface md:w-auto"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <template id="person-row-template">
            <div class="person-row grid gap-3 rounded-lg border border-border p-4 md:grid-cols-[1fr_1fr_auto]">
                <div>
                    <label
                        class="mb-1 block text-xs font-medium text-text"
                    >
                        Person
                    </label>

                    <select
                        name="people[__INDEX__][person_id]"
                        class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text"
                    >
                        <option value="">Select person</option>

                        @foreach ($people as $person)
                            <option value="{{ $person->id }}">
                                {{ $person->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label
                        class="mb-1 block text-xs font-medium text-text"
                    >
                        Role
                    </label>

                    <input
                        type="text"
                        name="people[__INDEX__][role]"
                        placeholder="e.g. Researcher"
                        class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text"
                    >
                </div>

                <div class="flex items-end">
                    <button
                        type="button"
                        class="remove-person w-full rounded-md border border-border px-3 py-2 text-xs font-medium text-text-muted transition hover:bg-surface md:w-auto"
                    >
                        Remove
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{--Current Featured Image--}}
    @if (isset($project) && $project->featured_image_url)
        <div class="mb-4 flex flex-col gap-4">
            <p class="text-sm font-medium text-text">
                Current Featured Image
            </p>

            <div class="overflow-hidden rounded-lg border border-border bg-surface">
                <div class="aspect-video">
                    <img
                        src="{{ $project->featured_image_url }}"
                        alt="{{ $project->title }}"
                        class="h-full w-full object-cover"
                    >
                </div>
            </div>

            <div>
                <button
                    type="button"
                    id="remove-featured-image-button"
                    class="rounded-md border border-error px-3 py-2 text-sm font-medium text-error hover:bg-error-light"
                >
                    Remove Featured Image
                </button>
            </div>
       </div>
    @endif

    {{-- Featured Image --}}
    <div>
        <label
            for="featured_image"
            class="block text-sm font-medium text-text"
        >
            Featured Image
        </label>

        <input
            type="file"
            id="featured_image"
            name="featured_image"
            accept=".jpg,.jpeg,.png,.webp"
            class="mt-1.5 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text file:mr-4 file:rounded-md file:border-0 file:bg-surface file:px-3 file:py-2 file:text-sm file:font-medium file:text-text hover:file:bg-surface-hover"
        >

        <p class="mt-1.5 text-xs text-text-muted">
            JPG, JPEG, PNG, atau WebP. Maksimal 5 MB.
        </p>

        @error('featured_image')
            <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label
            for="status"
            class="mb-2 block text-sm font-medium text-text"
        >
            Status
        </label>

        <select
            id="status"
            name="status"
            class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
        >
            @foreach ([
                'planned' => 'Planned',
                'ongoing' => 'Ongoing',
                'completed' => 'Completed',
                'archived' => 'Archived',
            ] as $value => $label)

                <option
                    value="{{ $value }}"
                    @selected(old('status', $project->status ?? '') === $value)
                >
                    {{ $label }}
                </option>

            @endforeach
        </select>

        @error('status')
            <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Dates --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

        <div>
            <label
                for="start_date"
                class="mb-2 block text-sm font-medium text-text"
            >
                Start Date
            </label>

            <input
                type="date"
                id="start_date"
                name="start_date"
                value="{{ old('start_date', isset($project->start_date) ? $project->start_date->format('Y-m-d') : '') }}"
                class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
            >

            @error('start_date')
                <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label
                for="end_date"
                class="mb-2 block text-sm font-medium text-text"
            >
                End Date
            </label>

            <input
                type="date"
                id="end_date"
                name="end_date"
                value="{{ old('end_date', isset($project->end_date) ? $project->end_date->format('Y-m-d') : '') }}"
                class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
            >

            @error('end_date')
                <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- Location --}}
    <div>
        <label
            for="location"
            class="mb-2 block text-sm font-medium text-text"
        >
            Location
        </label>

        <input
            type="text"
            id="location"
            name="location"
            value="{{ old('location', $project->location ?? '') }}"
            class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text placeholder:text-text-subtle focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
        >

        @error('location')
            <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Funding Source --}}
    <div>
        <label
            for="funding_source"
            class="mb-2 block text-sm font-medium text-text"
        >
            Funding Source
        </label>

        <input
            type="text"
            id="funding_source"
            name="funding_source"
            value="{{ old('funding_source', $project->funding_source ?? '') }}"
            class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text placeholder:text-text-subtle focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
        >

        @error('funding_source')
            <p class="mt-1.5 text-sm text-error">{{ $message }}</p>
        @enderror
    </div>


    <input
        type="hidden"
        name="fromDashboard"
        value="{{ $fromDashboard ? '1' : '0' }}"
    >

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('people-container');
        const addButton = document.getElementById('add-person');
        const template = document.getElementById('person-row-template');

        let index = container.querySelectorAll('.person-row').length;

        addButton.addEventListener('click', () => {
            const html = template.innerHTML.replaceAll(
                '__INDEX__',
                index
            );

            container.insertAdjacentHTML('beforeend', html);

            index++;
        });

        container.addEventListener('click', (event) => {
            const button = event.target.closest('.remove-person');

            if (!button) {
                return;
            }

            const rows = container.querySelectorAll('.person-row');

            if (rows.length === 1) {
                const row = button.closest('.person-row');

                row.querySelector('select').value = '';
                row.querySelector('input').value = '';

                return;
            }

            button.closest('.person-row').remove();
        });
    });
</script>
