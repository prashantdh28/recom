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
    <div class="container-fixed" x-data="{ toggleDrawer: false }">
        <div class="grid gap-5 lg:gap-7.5">
            <div class="card card-grid min-w-full">
                <div class="card-body">
                    <div>
                        <x-list.header>
                            <x-slot name="search"></x-slot>

                            <x-slot name="filter"></x-slot>
                        </x-list.header>
                        <div class="scrollable-x-auto">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DRAWER COMPONENT -->
        <div id="drawer-contact" @click.outside="toggleDrawer = false"
            :class="toggleDrawer ? 'drawer -translate-x-full' : 'translate-x-full'"
            class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform bg-white w-80 dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-contact-label">
            <h5 id="drawer-label"
                class="inline-flex items-center mb-6 text-base font-semibold text-gray-500 uppercase dark:text-gray-400">
                Filter
            </h5>
            <button type="button" @click="toggleDrawer = !toggleDrawer" data-drawer-hide="drawer-contact"
                aria-controls="drawer-contact"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <form name='advance_filter_form' id='advance-filter' onsubmit='return false' method="POST">
                @csrf

                <div class="card-body">
                    <div class="card-body p-0">
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
                <div class="card-footer text-end py-3 fixed right-0 bottom-0 space-x-2">
                    <button class="btn btn-light" type="button" id="advance-filter-reset">Reset</button>
                    <button class="btn btn-primary" type="submit" id="advance-submit" name="submit">Apply</button>
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
