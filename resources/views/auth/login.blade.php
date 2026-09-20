@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Login')

@section('content')

<div class="mx-auto flex min-h-[70vh] w-full max-w-md items-center px-4 py-10 sm:px-6">

    <div class="w-full rounded-lg border border-border bg-surface p-6 sm:p-8">

        <div class="mb-8">
            <p class="text-sm font-medium text-primary">
                Mikroliterasi
            </p>

            <h1 class="mt-2">
                Sign in
            </h1>

            <p class="mt-2 text-sm text-text-muted">
                Sign in to manage research projects.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-md border border-info bg-info-light px-4 py-3 text-sm text-info">
                {{ session('status') }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('login') }}"
            class="space-y-5"
        >
            @csrf

            <div>
                <label
                    for="email"
                    class="mb-2 block text-sm font-medium text-text"
                >
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('email')
                    <p class="mt-1.5 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label
                    for="password"
                    class="mb-2 block text-sm font-medium text-text"
                >
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-md border border-border bg-background px-3 py-2.5 text-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >

                @error('password')
                    <p class="mt-1.5 text-sm text-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input
                    id="remember"
                    type="checkbox"
                    name="remember"
                    value="1"
                    class="size-4 rounded border-border text-primary focus:ring-primary"
                >

                <label
                    for="remember"
                    class="text-sm text-text-muted"
                >
                    Remember me
                </label>
            </div>

            <button
                type="submit"
                class="w-full rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white hover:bg-primary-hover"
            >
                Sign in
            </button>

        </form>

    </div>

</div>

@endsection
