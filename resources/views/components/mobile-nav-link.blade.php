@props([
    'href',
    'active' => false,
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'block w-full px-3 py-3 text-sm font-medium transition ' .
            ($active
                ? 'bg-background text-primary'
                : 'text-text-muted hover:bg-background hover:text-primary'),
    ]) }}
>
    {{ $slot }}
</a>
