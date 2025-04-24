<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr" lang="en">

<head>
    <base href="../../../">
    <title>{{ config('app.name') }} - @yield('title', 'Dashboard')</title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/dashboards/dark-sidebar" rel="canonical" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="Dark Sidebar style dashboard with data widgets and interactive charts" name="description" />
    <meta content="@keenthemes" name="twitter:site" />
    <meta content="@keenthemes" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="Metronic - Tailwind CSS Dark Sidebar" name="twitter:title" />
    <meta content="Dark Sidebar style dashboard with data widgets and interactive charts" name="twitter:description" />
    <meta content="assets/media/app/og-image.png" name="twitter:image" />
    <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/dashboards/dark-sidebar" property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="@keenthemes" property="og:site_name" />
    <meta content="Metronic - Tailwind CSS Dark Sidebar" property="og:title" />
    <meta content="Dark Sidebar style dashboard with data widgets and interactive charts" property="og:description" />
    <meta content="assets/media/app/og-image.png" property="og:image" />
    <link href="assets/media/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="assets/media/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png" />
    <link href="assets/media/app/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png" />
    <link href="{{ asset('assets/media/recom_48*48.ico') }}" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    {{-- <script type="module" src="https://cdn.datatables.net/2.2.2/js/dataTables.tailwindcss.js"></script> --}}
    @if (request()->routeIs('*.index'))
        @vite(['resources/js/datatable-tailwind.js'])
    @endif
</head>

<body class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:#fefefe] [--tw-page-bg-dark:var(--tw-coal-500)] demo1 sidebar-fixed header-fixed bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]">
    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('theme')) {
                themeMode = localStorage.getItem('theme');
            } else if (document.documentElement.hasAttribute('data-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!-- End of Theme Mode -->
    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- End of Sidebar -->
        <!-- Wrapper -->
        <div class="wrapper flex grow flex-col">
            <!-- Header -->
            <header class="header fixed top-0 z-10 start-0 end-0 flex items-stretch shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]"
                data-sticky="true" data-sticky-class="shadow-sm" data-sticky-name="header" id="header">
                <!-- Container -->
                <div class="container-fixed flex justify-between items-stretch lg:gap-4" id="header_container">
                    <!-- Mobile Logo -->
                    <div class="flex gap-1 lg:hidden items-center -ms-1">
                        <a class="shrink-0" href="{{ route('dashboard') }}">
                            {{-- <img class="max-h-[25px] w-full" src="assets/media/app/mini-logo.svg" /> --}}
                            <x-application-logo />
                        </a>
                    </div>
                    <!-- End of Mobile Logo -->
                    @yield('breadcrumbs')
                    <!--Megamenu Contaoner-->
                    <div class="flex items-stretch" id="mega_menu_container">
                        <!--Megamenu Inner-->
                        
                        <!--End of Megamenu Inner-->
                    </div>
                    <!--End of Megamenu Contaoner-->
                    <!-- Topbar -->
                    <div class="flex items-center gap-2 lg:gap-3.5">
                        
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="20px, 10px"
                                data-menu-item-offset-rtl="-20px, 10px" data-menu-item-placement="bottom-end"
                                data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                data-menu-item-trigger="click|lg:click">
                                <div class="menu-toggle btn btn-icon rounded-full">
                                    <img alt="" class="size-9 rounded-full border-2 border-success shrink-0"
                                        src="{{ asset('assets/media/avatars/300-2.png') }}">
                                    </img>
                                </div>
                                <div class="menu-dropdown menu-default light:border-gray-300 w-screen max-w-[250px]">
                                    <div class="flex items-center justify-between px-5 py-1.5 gap-1.5">
                                        <div class="flex items-center gap-2">
                                            <img alt="" class="size-9 rounded-full border-2 border-success"
                                                src="{{ asset('assets/media/avatars/300-2.png') }}">
                                            <div class="flex flex-col gap-1.5">
                                                <span class="text-sm text-gray-800 font-semibold leading-none">
                                                    {{ auth()->user()->name }}
                                                </span>
                                                <a class="text-xs text-gray-600 hover:text-primary font-medium leading-none"
                                                    href="html/demo1/account/home/get-started.html">
                                                    {{ auth()->user()->email }}
                                                </a>
                                            </div>
                                            </img>
                                        </div>
                                    </div>

                                    <div class="menu-separator">
                                    </div>
                                    
                                    <div class="flex flex-col">
                                        <div class="menu-item mb-0.5">
                                            <div class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="ki-filled ki-moon">
                                                    </i>
                                                </span>
                                                <span class="menu-title">
                                                    Dark Mode
                                                </span>
                                                <label class="switch switch-sm">
                                                    <input data-theme-state="dark" data-theme-toggle="true"
                                                        name="check" type="checkbox" value="1">
                                                    </input>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="menu-item px-4 py-1.5">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="btn btn-sm btn-light justify-center"
                                                    href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();this.closest('form').submit();"
                                                >
                                                    Log out
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End of Topbar -->
                </div>
                <!-- End of Container -->
            </header>
            <!-- End of Header -->
            <!-- Content -->
            <main class="grow content pt-5" id="content" role="content">
                @yield('content')
            </main>
            <!-- End of Content -->
            <!-- Footer -->
            {{-- @include('layouts.footer') --}}
            <!-- End of Footer -->
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @routes
    <!-- Scripts -->
    @stack('scripts')
    <!-- End of Scripts -->
</body>

</html>
