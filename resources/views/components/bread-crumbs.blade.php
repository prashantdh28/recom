<!-- Breadcrumbs -->
@if($breadcrumbs)
<div class="flex [.header_&]:below-lg:hidden items-center gap-1.25 text-xs lg:text-sm font-medium mb-2.5 lg:mb-0"
    data-reparent="true" data-reparent-mode="prepend|lg:prepend"
    data-reparent-target="#content_container|lg:#header_container">
    @foreach ($breadcrumbs as $breadcrumb)
        @if (isset($breadcrumb['url']))
            <a href="{{ $breadcrumb['url'] }}" class="text-gray-700 hover:underline">{{ $breadcrumb['name'] }}</a>
        @else
            <span class="text-gray-700">{{ $breadcrumb['name'] ?? $breadcrumb }}</span>
        @endif

        @if (!$loop->last)
            <i class="ki-filled ki-right text-gray-500 text-3xs"></i>
        @endif
    @endforeach
</div>
@endif
<!-- End of Breadcrumbs -->
