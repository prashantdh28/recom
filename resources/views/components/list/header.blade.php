<div class="flex justify-between items-center mb-2">
    {{-- Search Slot --}}
    @isset($search)
        <x-list.search />
    @endisset

    <div class="flex justify-between items-center space-x-4">
        {{-- Any Button Slot --}}
        @isset($button)
            {{ $button }}
        @endisset

        {{-- Filter Slot --}}
        @isset($filter)
            <x-list.filter />
        @endisset
    </div>
</div>