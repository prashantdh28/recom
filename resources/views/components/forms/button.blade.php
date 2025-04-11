@props(['link'])
<div class="flex justify-end p-2">
    {{-- Submit Button Slot --}}
    {{ $submitBtn }}

    {{-- Cancel Button Slot --}}
    <a href="{{ $link }}">
        {{ $cancelBtn }}
    </a>
</div>