@props(['editLink' => 'javascript:void(0)', 'deleteLink' => null])
<div class="flex justify-center item-center">
    <a href="{{ $editLink }}">
        <button class="btn btn-icon btn-clear btn-light">
            <i class="ki-outline ki-notepad-edit"></i>
        </button>
    </a>
    @if($deleteLink)
        <a href="{{ $deleteLink }}">
            <button class="btn btn-icon btn-clear btn-primary">
                <i class="ki-outline ki-trash"></i>
            </button>
        </a>
    @endif
</div>
