<x-badge
    class="{{ $label ? \App\Enums\AccountConfigEnum::badgeClass($label) : '' }}"
    :label="$label"
/>