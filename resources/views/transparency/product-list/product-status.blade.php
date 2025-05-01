<x-badge
    class="{{ $label ? \App\Enums\ProductListEnum::badgeClass($label) : '' }}"
    :label="$label"
/>