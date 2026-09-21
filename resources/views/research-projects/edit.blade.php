@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Edit | ' . $researchProject->title)

@section('content')

@php
    $project = $researchProject;
@endphp

<div class="mx-auto w-full max-w-205 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

    <div class="mb-8">
        <a
            href="{{ route('research-projects.show', $project) }}"
            class="text-sm text-text-muted hover:text-primary"
        >
            ← Research Project
        </a>

        <h1 class="mt-4">Edit Research Project</h1>

        <p class="mt-2 text-text-muted">
            Update the research project information.
        </p>
    </div>

    <form
        action="{{ route('research-projects.update', $project) }}"
        method="POST"
        enctype="multipart/form-data"
        class="rounded-lg border border-border bg-surface p-5 sm:p-6"
    >
        @csrf
        @method('PUT')

        @include('research-projects._form')

        <div class="mt-8 flex items-center justify-end gap-3 border-t border-border pt-6">

            <a
                href="{{ route('research-projects.show', $project) }}"
                class="rounded-md border border-border-strong px-4 py-2 text-sm font-medium text-text hover:bg-background"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover"
            >
                Save Changes
            </button>

        </div>
    </form>

</div>

@endsection
