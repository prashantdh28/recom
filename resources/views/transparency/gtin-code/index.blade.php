@extends('layouts.app')

@section('title', 'Transparency GTIN Code List')

@section('breadcrumbs')
    <div class="flex [.header_&]:below-lg:hidden items-center gap-1.25 text-xs lg:text-sm font-medium mb-2.5 lg:mb-0"
        data-reparent="true" data-reparent-mode="prepend|lg:prepend"
        data-reparent-target="#content_container|lg:#header_container">
        <span class="text-gray-700">
            Transparency Management
        </span>
        <i class="ki-filled ki-right text-gray-500 text-3xs">
        </i>
        <span class="text-gray-700">
            GTIN Code History
        </span>
        <i class="ki-filled ki-right text-gray-500 text-3xs">
        </i>
        <span class="text-gray-700">
            Listing
        </span>
    </div>
@endsection

@section('content')
    <!-- Container -->
    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <div class="card card-grid min-w-full">
                <div class="card-body">
                    <div>
                        <x-list.header>
                            <x-slot name="search"></x-slot>

                            <x-slot name="filter"></x-slot>
                        </x-list.header>
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DRAWER COMPONENT -->
        <div class="drawer drawer-end flex flex-col max-w-[90%] w-[400px]" data-drawer="true" id="filter-sidebar">
            <form id="filter_form">
                <div class="flex items-center justify-between p-5 border-b">
                    <h3 class="text-base font-semibold text-gray-900">
                        Filter
                    </h3>
                    <button class="btn btn-xs btn-icon btn-light" id="close-filter-sidebar" data-drawer-dismiss="true">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-auto">
                    <div class="grid grid-cols-1 gap-3 p-5 xl:pr-2 scrollable-y">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item filterform border-0">

                                <div class="mb-5">
                                    <label class="form-label">Status</label>
                                    <select class="select" name="status">
                                        <option value="">--Select--</option>
                                        @forelse ($status as $key => $value)
                                            <option value="{{ $value }}">{{ $key }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-4 p-5 border-t">
                    <button class="btn btn-sm btn-danger" type="button" id="reset-filter-sidebar">Reset</button>
                    <button class="btn btn-sm btn-primary" type="button" id="flt_submit">Apply</button>
                </div>
            </form>
        </div>
        <!-- END DRAWER COMPONENT -->
    </div>
    <!-- End of Container -->

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

@endsection

@push('scripts')
    @vite('resources/js/gtin-code/index.js')
@endpush
