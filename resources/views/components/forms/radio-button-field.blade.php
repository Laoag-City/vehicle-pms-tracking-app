@props([
	'label',
    'name',
    'values',
	'checked' => null,
	'error' => "",
	'required' => false,
	'inline' => true,
	'jsBind' => '{}'
])

<div {{ $attributes->class(['inline' => $inline, 'grouped' => !$inline, 'fields', 'error' => !!$error, ]) }} {!! !$error ?: 'data-tooltip="' . $error . '"' !!}>
	<label for="{{ $name }}">
		<b>{{ $label }}</b>
	</label>

	@foreach($values as $value)
		<div class="field">
			<div class="ui radio checkbox">
				<input 
					type="radio" 
					id="{{ "$name-$value" }}" 
					name="{{ $name }}" 
					value="{{ $value }}" 
					{{ !$required ?: 'required' }}
					{{ $value != $checked ?: 'checked' }}
					class="hidden"
					tabindex="0"
					x-bind="{{ $jsBind }}"
				>
				<label>{{ $value }}</label>
			</div>
		</div>
	@endforeach
</div>