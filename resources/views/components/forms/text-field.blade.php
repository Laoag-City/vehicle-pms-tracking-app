@props([
    'label',
    'name',
    'value',
    'type' => 'text',
    'error' => "",
    'placeholder' => "",
    'required' => false,
    'readonly' => false,
    'min' => null,
    'max' => null,
    'step' => null,
    'jsBind' => '{}'
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
        {{ !$step ?: "step=$step" }}
        {{ !$required ?: 'required' }}
        {{ !$readonly ?: 'readonly' }}
        x-bind="{{ $jsBind }}"
    >
</div>