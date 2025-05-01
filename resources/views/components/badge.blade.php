@props(['label' => "Default"])

<span {{ $attributes->merge(['class' => 'badge']) }}>
    {{ $label }}
</span>