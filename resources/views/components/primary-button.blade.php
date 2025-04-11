<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary flex justify-center item-center m-2']) }}>
    {{ $slot }}
</button>
