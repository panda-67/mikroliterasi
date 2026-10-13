<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', config('app.name', 'Mikroliterasi'))
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col bg-background text-text">

    @include('components.navbar')

    @auth
        <div class="border-b border-border bg-background">
            <div class="mx-auto flex min-h-10 w-full max-w-300
                        items-center justify-between gap-3 px-4
                        sm:px-6 lg:px-8">

                <div class="flex min-w-0 items-center gap-2 text-xs">
                    <span class="shrink-0 font-medium text-text">
                        {{ auth()->user()->name }}
                    </span>

                    <span class="text-text-muted">/</span>

                    <span class="truncate text-text-muted">
                        {{ auth()->user()->email }}
                    </span>
                </div>

                <div class="flex shrink-0 items-center gap-3">
                    <span class="hidden text-xs text-text-muted sm:inline">
                        {{ ucfirst(auth()->user()->role->value ?? auth()->user()->role) }}
                    </span>
               </div>

            </div>
        </div>
    @endauth

    <main class="flex-1">

        <x-flash-message />

        @yield('content')

    </main>

    @include('components.footer')

</body>

</html>
