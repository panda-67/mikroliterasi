@php
    $messages = [
        'success' => [
            'label' => 'Success',
            'class' => 'border-success/50 bg-success/20 text-success',
        ],
        'error' => [
            'label' => 'Error',
            'class' => 'border-error/50 bg-error/20 text-error',
        ],
        'warning' => [
            'label' => 'Warning',
            'class' => 'border-warning/50 bg-warning/20 text-warning',
        ],
        'info' => [
            'label' => 'Info',
            'class' => 'border-primary/50 bg-primary/20 text-primary',
        ],
    ];
@endphp

@foreach ($messages as $type => $message)
    @if (session()->has($type))
        <div
            class="flash-message fixed right-4 top-20 z-50 w-[calc(100%-2rem)] max-w-md rounded-md border px-4 py-3 shadow-sm {{ $message['class'] }}"
            role="alert"
        >
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-sm font-medium">
                        {{ $message['label'] }}
                    </p>

                    <p class="mt-1 text-sm">
                        {{ session($type) }}
                    </p>
                </div>

                <button
                    type="button"
                    class="shrink-0 text-current opacity-70 transition hover:opacity-100"
                    onclick="this.closest('.flash-message').remove()"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
@endforeach

<script>
    document.querySelectorAll('.flash-message').forEach((message) => {
        setTimeout(() => {
            message.remove();
        }, 4000);
    });
</script>
