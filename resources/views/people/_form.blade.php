<div class="space-y-10">

    {{-- Personal information --}}
    <section>
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Personal information
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                Basic information about the researcher or institute member.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Name --}}
            <div class="md:col-span-2">
                <label
                    for="name"
                    class="block text-sm font-medium text-text"
                >
                    Name
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $person->name ?? '') }}"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('name')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Position --}}
            <div>
                <label
                    for="position"
                    class="block text-sm font-medium text-text"
                >
                    Position
                </label>

                <input
                    type="text"
                    name="position"
                    id="position"
                    value="{{ old('position', $person->position ?? '') }}"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('position')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label
                    for="email"
                    class="block text-sm font-medium text-text"
                >
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $person->email ?? '') }}"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('email')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Website --}}
            <div class="md:col-span-2">
                <label
                    for="website"
                    class="block text-sm font-medium text-text"
                >
                    Website
                </label>

                <input
                    type="url"
                    name="website"
                    id="website"
                    value="{{ old('website', $person->website ?? '') }}"
                    placeholder="https://..."
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('website')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Short bio --}}
            <div class="md:col-span-2">
                <label
                    for="short_bio"
                    class="block text-sm font-medium text-text"
                >
                    Short bio
                </label>

                <textarea
                    name="short_bio"
                    id="short_bio"
                    rows="4"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm leading-6 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >{{ old('short_bio', $person->short_bio ?? '') }}</textarea>

                @error('short_bio')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Biography --}}
            <div class="md:col-span-2">
                <label
                    for="bio"
                    class="block text-sm font-medium text-text"
                >
                    Biography
                </label>

                <textarea
                    name="bio"
                    id="bio"
                    rows="8"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm leading-6 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >{{ old('bio', $person->bio ?? '') }}</textarea>

                @error('bio')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </section>


    {{-- Academic profiles --}}
    <section class="border-t border-border pt-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Academic profiles
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                External academic profiles and researcher identifiers.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Scopus --}}
            <div>
                <label
                    for="scopus"
                    class="block text-sm font-medium text-text"
                >
                    Scopus
                </label>

                <input
                    type="url"
                    name="scopus"
                    id="scopus"
                    value="{{ old('scopus', $person->scopus ?? '') }}"
                    placeholder="https://..."
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('scopus')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Google Scholar --}}
            <div>
                <label
                    for="google_scholar"
                    class="block text-sm font-medium text-text"
                >
                    Google Scholar
                </label>

                <input
                    type="url"
                    name="google_scholar"
                    id="google_scholar"
                    value="{{ old('google_scholar', $person->google_scholar ?? '') }}"
                    placeholder="https://scholar.google.com/..."
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('google_scholar')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- ORCID --}}
            <div>
                <label
                    for="orcid"
                    class="block text-sm font-medium text-text"
                >
                    ORCID
                </label>

                <input
                    type="url"
                    name="orcid"
                    id="orcid"
                    value="{{ old('orcid', $person->orcid ?? '') }}"
                    placeholder="https://orcid.org/..."
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('orcid')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- SINTA --}}
            <div>
                <label
                    for="sinta"
                    class="block text-sm font-medium text-text"
                >
                    SINTA
                </label>

                <input
                    type="url"
                    name="sinta"
                    id="sinta"
                    value="{{ old('sinta', $person->sinta ?? '') }}"
                    placeholder="https://sinta.kemdikbud.go.id/..."
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('sinta')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </section>


    {{-- Academic information --}}
    <section class="border-t border-border pt-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Academic information
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                Educational background and areas of research interest.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6">

            {{-- Education --}}
            <div>
                <label
                    for="education"
                    class="block text-sm font-medium text-text"
                >
                    Education
                </label>

                <textarea
                    name="education"
                    id="education"
                    rows="6"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm leading-6 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >{{ old('education', $person->education ?? '') }}</textarea>

                @error('education')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Research interests --}}
            <div>
                <label
                    for="research_interests"
                    class="block text-sm font-medium text-text"
                >
                    Research interests
                </label>

                <textarea
                    name="research_interests"
                    id="research_interests"
                    rows="6"
                    class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm leading-6 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >{{ old('research_interests', $person->research_interests ?? '') }}</textarea>

                @error('research_interests')
                    <p class="mt-1 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </section>


    {{-- Status --}}
    <section class="border-t border-border pt-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-text">
                Status
            </h2>
            <p class="mt-1 text-sm text-text-muted">
                Control whether this person is currently active on the website.
            </p>
        </div>

        <div>
            <label
                for="status"
                class="block text-sm font-medium text-text"
            >
                Status
            </label>

            <select
                name="status"
                id="status"
                class="mt-2 block w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
            >
                <option
                    value="active"
                    @selected(
                        old('status', $person->status ?? 'active') === 'active'
                    )
                >
                    Active
                </option>

                <option
                    value="inactive"
                    @selected(
                        old('status', $person->status ?? '') === 'inactive'
                    )
                >
                    Inactive
                </option>
            </select>

            @error('status')
                <p class="mt-1 text-sm text-error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </section>


    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3 border-t border-border pt-8">

        <a
            href="{{ isset($person)
                ? route('people.show', $person->slug)
                : route('people.index') }}"
            class="rounded-md border border-border-strong px-4 py-2 text-sm font-medium text-text hover:bg-background"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
        >
            {{ isset($person) ? 'Update Person' : 'Create Person' }}
        </button>

    </div>

</div>
