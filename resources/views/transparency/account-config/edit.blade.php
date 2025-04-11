@extends('layouts.app')

@section('title', 'Account Config Create')

@section('breadcrumbs')
    <!-- Breadcrumbs -->
    <x-bread-crumbs :breadcrumbs="\App\Config\AccountConfig::generateBreadcrumbs('edit')" />
    <!-- End of Breadcrumbs -->
@endsection

@section('content')
    <!-- Container -->
    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <div class="card card-grid min-w-full">
                <div class="card-body !p-2">
                    <form action="{{ route('account-config.update', ['account_config' => $accountConfig]) }}" method="POST" id="account_config">
                        @method('PUT')
                        @csrf

                        <div class="grid grid-cols-3 gap-4">
                            <!-- Business Account Name -->
                            <x-forms.div>
                                <x-slot name="label">
                                    <x-input-label value="Business Account Name" />
                                </x-slot>
                            
                                <x-slot name="input">
                                    <x-text-input name="name" placeholder="Enter Business Account Name" type="text" value="{{ $accountConfig->name }}" />
                                </x-slot>
                            </x-forms.div>

                            <!-- Client ID -->
                            <x-forms.div>
                                <x-slot name="label">
                                    <x-input-label value="Client ID" />
                                </x-slot>
                            
                                <x-slot name="input">
                                    <x-text-input name="client_id" placeholder="Enter Client ID" type="text" value="{{ $accountConfig->client_id }}" />
                                </x-slot>
                            </x-forms.div>
                        </div>

                        <x-forms.button :link="route('account-config.index')">
                            <x-slot name="submitBtn">
                                <x-primary-button>
                                    Update
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

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateAccountRequest', '#account_config') !!}
@endsection
