@extends('layouts.app')

@section('title', 'Upload Product File')

@section('breadcrumbs')
    <!-- Breadcrumbs -->
    <div class="flex [.header_&]:below-lg:hidden items-center gap-1.25 text-xs lg:text-sm font-medium mb-2.5 lg:mb-0"
        data-reparent="true" data-reparent-mode="prepend|lg:prepend"
        data-reparent-target="#content_container|lg:#header_container">
        <span class="text-gray-700">
            Transparency Management
        </span>
        <i class="ki-filled ki-right text-gray-500 text-3xs">
        </i>
        <span class="text-gray-700">
            Product File
        </span>
        <i class="ki-filled ki-right text-gray-500 text-3xs">
        </i>
        <span class="text-gray-700">
            Upload Product File
        </span>
    </div>
    <!-- End of Breadcrumbs -->
@endsection

@section('content')
    <!-- Container -->
    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <div class="card card-grid min-w-full">
                <div class="card-body !p-2">
                    <form action="{{ route('product-file.store') }}" method="POST" id="product_file" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <div class="flex items-baseline flex-wrap gap-2.5">
                                    <label class="form-label">Business Account Name</label>
                                    <select class="select" name="account_config_id">
                                        <option value="">--Select--</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-baseline flex-wrap gap-2.5">
                                    <label class="form-label">Import File</label>
                                    <input class="file-input" type="file" name="file_name" accept=".xlsv, .xls, .xlsx" />
                                </div>
                            </div>
                        </div>

                        {{-- <div class="grid grid-cols-2 gap-6" style="border: 1px solid black"> --}}
                        {{-- <div class="flex justify-end p-2">
                            <button type="submit" class="btn btn-primary max-w-[25%] flex justify-center item-center m-2">
                                Save
                            </button>

                            <button type="button" class="btn btn-danger max-w-[25%] flex justify-center item-center m-2">
                                Cancel
                            </button>
                        </div> --}}

                        <x-forms.button :link="route('product-file.index')">
                            <x-slot name="submitBtn">
                                <x-primary-button class="max-w-[25%]">
                                    Save
                                </x-primary-button>
                            </x-slot>

                            <x-slot name="cancelBtn">
                                <x-danger-button>
                                    Cancel
                                </x-danger-button>
                            </x-slot>
                        </x-forms.button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Container -->
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreTransparencyProductFileRequest', '#product_file') !!}
@endpush
