@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Edit | ' . $researchProject->title)

@section('content')

@php
    $project = $researchProject;
@endphp

<div class="mx-auto w-full max-w-205 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
    <div class="mb-8">
        <a
            href="{{ $fromDashboard
                ? route('dashboard.research-projects.index')
                : route('research-projects.show', $project) }}"
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
                href="{{ $fromDashboard
                    ? route('dashboard.research-projects.index')
                    : route('research-projects.show', $project) }}"
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

@if (isset($project) && $project->featured_image_url)

    <form
        id="remove-featured-image-form"
        action="{{ route('research-projects.featured-image.destroy', $project) }}"
        method="POST"
        class="hidden"
    >
        @csrf
        @method('DELETE')
    </form>

    <div
        id="remove-featured-image-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="remove-featured-image-title"
    >
        <div
            class="w-full max-w-md rounded-lg border border-border bg-background p-6 shadow-lg"
        >
            <h2
                id="remove-featured-image-title"
                class="text-lg font-semibold text-text"
            >
                Remove Featured Image
            </h2>

            <p class="mt-3 text-sm leading-6 text-text-muted">
                Are you sure you want to remove the featured image from
                <span class="font-medium text-text">
                    {{ $project->title }}
                </span>?
            </p>

            <p class="mt-2 text-sm leading-6 text-text-muted">
                The research project itself will not be deleted.
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    id="cancel-remove-featured-image"
                    class="rounded-md border border-border px-4 py-2 text-sm font-medium text-text hover:bg-surface"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="confirm-remove-featured-image"
                    class="rounded-md bg-error px-4 py-2 text-sm font-medium text-white hover:bg-error/90"
                >
                    Remove Image
                </button>
            </div>
        </div>
    </div>

    <script>
        const removeFeaturedImageButton = document.getElementById(
            'remove-featured-image-button'
        );

        const removeFeaturedImageModal = document.getElementById(
            'remove-featured-image-modal'
        );

        const cancelRemoveFeaturedImage = document.getElementById(
            'cancel-remove-featured-image'
        );

        const confirmRemoveFeaturedImage = document.getElementById(
            'confirm-remove-featured-image'
        );

        const removeFeaturedImageForm = document.getElementById(
            'remove-featured-image-form'
        );

        removeFeaturedImageButton?.addEventListener('click', () => {
            removeFeaturedImageModal.classList.remove('hidden');
            removeFeaturedImageModal.classList.add('flex');
        });

        cancelRemoveFeaturedImage?.addEventListener('click', () => {
            closeRemoveFeaturedImageModal();
        });

        confirmRemoveFeaturedImage?.addEventListener('click', () => {
            removeFeaturedImageForm?.submit();
        });

        removeFeaturedImageModal?.addEventListener('click', (event) => {
            if (event.target === removeFeaturedImageModal) {
                closeRemoveFeaturedImageModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeRemoveFeaturedImageModal();
            }
        });

        function closeRemoveFeaturedImageModal() {
            removeFeaturedImageModal.classList.remove('flex');
            removeFeaturedImageModal.classList.add('hidden');
        }
    </script>
@endif

@endsection
