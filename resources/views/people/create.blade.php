@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Create Person')

@section('content')

<div class="mx-auto w-full max-w-205 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

    <div class="mb-8">
        <a
            href="{{ route('people.index') }}"
            class="text-sm text-text-muted hover:text-primary"
        >
            ← People
        </a>

        <h1 class="mt-4">Create Person</h1>

        <p class="mt-2 text-text-muted">
            Add a new researcher or institute member to the database.
        </p>
    </div>

    <form
        action="{{ route('people.store') }}"
        method="POST"
        class="rounded-lg border border-border bg-surface p-5 sm:p-6"
    >
        @csrf

        @include('people._form')

   </form>

</div>

@endsection
