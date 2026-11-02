@extends('layouts.app')

@section('title', config('app.name', 'Mikroliterasi') . ' | Login')

@section('content')

<div class="mx-auto flex min-h-[95svh] w-full max-w-5xl items-center px-4 py-6 sm:px-6">

    <div class="w-full">

        <div class="mb-8 text-center">
            <h1 class="mt-2 text-2xl font-semibold text-text">
                Welcome back
            </h1>

            <p class="mt-2 text-sm text-text-muted">
                Choose your access method to continue.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            {{-- Institutional Access --}}
            <section class="rounded-lg border border-border bg-surface p-6 sm:p-8">

                <div class="mb-6">
                    <div class="mb-4 flex size-10 items-center justify-center rounded-lg bg-background text-text">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7">
                            <rect x="4" y="10" width="16" height="11" rx="2"/>
                            <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                            <path d="M12 14v3"/>
                        </svg>
                    </div>

                    <h2 class="text-lg font-semibold text-text">
                        Institutional Access
                    </h2>

                    <p class="mt-2 text-sm leading-relaxed text-text-muted">
                        For administrators, editors, and researchers
                        managing the Mikroliterasi platform.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-5 rounded-md border border-info bg-info-light px-4 py-3 text-sm text-info">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-text">
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
                            <p class="mt-1.5 text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-text">
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
                            <p class="mt-1.5 text-xs text-error">{{ $message }}</p>
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

                        <label for="remember" class="text-sm text-text-muted">
                            Remember me
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-md bg-primary px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-primary-hover"
                    >
                        Sign in
                    </button>
                </form>

            </section>

            {{-- Student Access --}}
            <section class="flex flex-col rounded-lg border border-border bg-surface p-6 sm:p-8">

                <div class="mb-6">
                    <div class="mb-4 flex size-10 items-center justify-center rounded-lg bg-background text-text">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7">
                            <path d="M2 9l10-5 10 5-10 5L2 9z"/>
                            <path d="M6 11v5c3.5 3 8.5 3 12 0v-5"/>
                            <path d="M22 9v6"/>
                        </svg>
                    </div>

                    <h2 class="text-lg font-semibold text-text">
                        Student Access
                    </h2>

                    <p class="mt-2 text-sm leading-relaxed text-text-muted">
                        For students who want to access learning
                        materials and educational resources.
                    </p>
                </div>

                <div class="flex flex-1 flex-col justify-center">

                    <div class="mb-6 rounded-md border border-border bg-background p-4">
                        <p class="text-sm font-medium text-text">
                            Learning Materials
                        </p>

                        <p class="mt-1 text-xs leading-relaxed text-text-muted">
                            Access educational content, learning resources,
                            and interactive materials through your Google account.
                        </p>
                    </div>

                    <a
                        href="{{ route('google.redirect') }}"
                        class="flex w-full items-center justify-center gap-3 rounded-md border border-border bg-background px-4 py-3 text-sm font-medium text-text transition-colors hover:bg-surface-hover"
                    >
                        <svg class="size-5" viewBox="0 0 48 48"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.73 7.18l7.62 5.91c4.45-4.11 7.15-10.15 7.15-17.56z"/>
                            <path fill="#FBBC05" d="M10.53 28.59A14.4 14.4 0 0 1 9.75 24c0-1.59.27-3.13.76-4.59l-7.98-6.19A23.9 23.9 0 0 0 0 24c0 3.87.93 7.52 2.56 10.78l7.97-6.19z"/>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.9-5.89l-7.62-5.91c-2.12 1.42-4.85 2.26-8.28 2.26-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                        </svg>

                        Continue with Google
                    </a>

                    @error('google')
                        <p class="mt-3 text-center text-xs text-error">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-4 text-center text-xs leading-relaxed text-text-muted">
                        Google Sign-In is exclusively available for students.
                    </p>

                </div>

            </section>

        </div>

    </div>

</div>

@endsection
