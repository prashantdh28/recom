@props(['disabled' => false, 'isForm' => true])

<input @disabled($disabled) {{ $attributes->merge(['class' => $isForm ? 'input' : '']) }}>
