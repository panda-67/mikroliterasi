@props([
    'name',
    'value' => '',
    'toolbar' => 'basic',
    'placeholder' => '',
    'height' => '250px',
    'uploadUrl' => null,
])

<div
    {{ $attributes->class('quill-wrapper') }}
    data-quill
    data-toolbar="{{ $toolbar }}"
    data-placeholder="{{ $placeholder }}"
    @if($uploadUrl) data-upload-url="{{ $uploadUrl }}" @endif
>
    <input type="hidden" name="{{ $name }}" value="{{ old($name, $value) }}" data-quill-input>
    <div data-quill-editor style="min-height: {{ $height }}"></div>
</div>
