@props([
	'label',
    'name',
    'value',
	'checked' => false,
	'error' => "",
	'required' => false,
	'checkboxClass' => 'toggle',
	'jsBind' => '{}'
])

<div {{ $attributes->class(['inline field', 'error' => !!$error, ]) }} {!! !$error ?: 'data-tooltip="' . $error . '"' !!}>
	<div class="ui {{ $checkboxClass }} checkbox">
		<input 
			type="checkbox" 
			id="{{ $name }}" 
			name="{{ $name }}" 
			value="{{ $value }}" 
			{{ !$required ?: 'required' }}
			{{ !$checked ?: 'checked' }}
			class="hidden"
			x-bind="{{ $jsBind }}"
		>
		<label for="{{ $name }}">
			<b>{{ $label }}</b>
		</label>
	</div>
</div>