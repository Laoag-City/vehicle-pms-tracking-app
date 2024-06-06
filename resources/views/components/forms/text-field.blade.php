@props([
    'label',
    'name',
    'value',
    'type' => 'text',
    'error' => "",
    'placeholder' => "",
    'required' => false,
    'min' => null,
    'max' => null
])

<div {{ $attributes->class(['field', 'error' => !!$error , 'no-display' => $type == 'hidden']) }} {!! !$error ?: 'data-tooltip="' . $error . '"' !!}>
    <label for="{{ $name }}">
        {{ $label }}
    </label>

    <input 
        id="{{ $name }}"
        type="{{ $type }}" 
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        min="{{ $min }}"
        max="{{ $max }}"
        {{ !$required ?: 'required' }}
    >
</div>