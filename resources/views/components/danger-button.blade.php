<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-danger flex justify-center item-center m-2']) }}>
    {{ $slot }}
</button>
