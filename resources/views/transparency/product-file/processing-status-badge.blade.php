<x-badge
    class="{{ $label ? \App\Enums\ProductFileEnum::badgeClass($label) : '' }}"
    :label="$label"
/>