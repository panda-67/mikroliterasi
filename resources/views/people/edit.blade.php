@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Edit Person')

@section('content')

<div class="mx-auto w-full max-w-205 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

    <div class="mb-8">
        <a
            href="{{ route('people.show', $person->slug) }}"
            class="text-sm text-text-muted hover:text-primary"
        >
            ← {{ $person->name }}
        </a>

        <h1 class="mt-4">Edit Person</h1>

        <p class="mt-2 text-text-muted">
            Update the academic profile and information for {{ $person->name }}.
        </p>
    </div>

    <form
        action="{{ route('people.update', $person->slug) }}"
        method="POST"
        class="rounded-lg border border-border bg-surface p-5 sm:p-6"
    >
        @csrf
        @method('PUT')

        @include('people._form')

   </form>

</div>

@endsection
