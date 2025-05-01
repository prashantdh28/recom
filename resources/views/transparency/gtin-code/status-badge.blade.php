<x-badge
    class="{{ $label ? \App\Enums\TransparencyCodeHistoryStatusEnum::badgeClass($label) : '' }}"
    :label="$label"
/>