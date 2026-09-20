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

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>

<body class="flex min-h-screen flex-col bg-background text-text">

    @include('components.navbar')

    <main class="flex-1">

        <x-flash-message />

        @yield('content')

    </main>

    @include('components.footer')

</body>

</html>
