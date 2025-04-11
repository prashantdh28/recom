{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Container -->
<div class="container-fixed" id="content_container">
</div>
<!-- End of Container -->
<!-- Container -->
<div class="container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-gray-900">
                Dashboard
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                Central Hub for Personal Customization
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a class="btn btn-sm btn-light" href="javascript:void(0)">
                View Profile
            </a>
        </div>
    </div>
</div>
<!-- End of Container -->
@endsection
