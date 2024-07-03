<div {{ $attributes->class('ui compact menu') }}>
	<div class="ui simple dropdown item">
		{{ $label }}
		<i class="dropdown icon"></i>

		<div class="menu">
			{{ $slot }}
		</div>
	</div>
</div>