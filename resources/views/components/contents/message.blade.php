<div {{ $attributes->merge(['class' => 'ui message']) }}>
    <i class="close icon"></i>
    <div class="header">
        {{ $header }}
    </div>
    {{ $slot }}
</div>