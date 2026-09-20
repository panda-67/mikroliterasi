@props([
    'href',
    'active' => false,
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'rounded-md px-3 py-2 text-sm font-medium transition ' .
            ($active
                ? 'bg-background text-primary'
                : 'text-text-muted hover:bg-background hover:text-primary'),
    ]) }}
>
    {{ $slot }}
</a>
