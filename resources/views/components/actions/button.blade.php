@props([
    'type' => 'button'
])

<button {{ $attributes->class('ui button') }} type="{{ $type }}">
    {{ $slot }}
</button>