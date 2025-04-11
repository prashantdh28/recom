@props(['toastType' => 'success', 'message' => ''])
<div x-data="{dismiss: false}">
    <template x-if="!dismiss">
        <div>
            @if ($toastType == 'success')
                <x-toast.success :message="$message" />
            @else
                <x-toast.error :message="$message" />
            @endif
        </div>
    </template>
</div>