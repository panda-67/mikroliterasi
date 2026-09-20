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

</div>
