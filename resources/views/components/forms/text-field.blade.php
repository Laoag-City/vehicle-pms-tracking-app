@props([
    'label',
    'name',
    'value',
    'type' => 'text',
    'error' => "",
    'placeholder',
    'required' => false
])

<div {{ $attributes->class(['field', 'error' => !!$error ]) }} {!! !$error ?: 'data-tooltip="' . $error . '"' !!}>
    <label for="{{ $name }}">
        {{ $label }}
    </label>

    <input 
        id="{{ $name }}"
        type="{{ $type }}" 
        name="{{ $name }}"
        value="{{ $value }}"
        {{ !$required ?: 'required' }}
    >
</div>