@extends('layouts.app')

@section('title', 'Account Config List')

@section('breadcrumbs')
    <x-bread-crumbs :breadcrumbs="\App\Config\AccountConfig::generateBreadcrumbs()" />
@endsection

@section('content')
    <!-- Container -->
    <div class="container-fixed" x-data="{toggleDrawer: false}">
        <div class="grid gap-5 lg:gap-7.5">
            <div class="card card-grid min-w-full">
                <div class="card-body">
                    <div data-datatable="false" data-datatable-page-size="20">
                        {{-- <a href="{{ action([\App\Http\Controllers\TransparencyCodeController::class, 'index']); }}">Chekc</a> --}}
                        <x-list.header>
                            <x-slot name="search"></x-slot>

                            <x-slot name="button">
                                <a href="{{ route('account-config.create') }}">
                                    <x-primary-button>
                                        Add
                                        <i class="ki-outline ki-plus-squared"></i>
                                    </x-primary-button>
                                </a>
                            </x-slot>
                                
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
            class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform bg-white w-80 dark:bg-gray-800"
            :class="toggleDrawer ? 'drawer -translate-x-full': 'translate-x-full'" tabindex="-1" aria-labelledby="drawer-contact-label">
            <h5 id="drawer-label"
                class="inline-flex items-center mb-6 text-base font-semibold text-gray-500 uppercase dark:text-gray-400">
                Filter
            </h5>
            <button type="button" @click="toggleDrawer = !toggleDrawer" data-drawer-hide="drawer-contact" aria-controls="drawer-contact"
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
    <script type="module">
        window.flashMessage = {
            success: @json(session('success')),
            error: @json(session('error'))
        };
    </script>
    @vite('resources/js/account-config/index.js')
@endpush
