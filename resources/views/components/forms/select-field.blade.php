@props([
    'label',
    'name',
    'options',
    'selected' => null,
    'error' => "",
    'placeholder' => "",
    'required' => false,
    'jsBind' => '{}'
])

<div {{ $attributes->class(['field', 'error' => !!$error ]) }} {!! !$error ?: 'data-tooltip="' . $error . '"' !!}>
    <label for="{{ $name }}">
        {{ $label }}
    </label>

    <select id="{{ $name }}" name="{{ $name }}" {{ !$required ?: 'required' }} x-bind="{{ $jsBind }}">
        <option>{{ $placeholder }}</option>
        @foreach($options as $option)
            <option value="{{ $option->selectValue() }}" {{ $selected != $option->selectValue() ?: 'selected' }}>{{ $option->selectName() }}</option>
        @endforeach
    </select>
</div>