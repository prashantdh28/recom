<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr" lang="en">

<head>
    <base href="../../../../../">
    <title>{{ config('app.name') }} - @yield('title', 'Login Page')</title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/authentication/branded/sign-in/index.html"
        rel="canonical" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="Sign in page, using Tailwind CSS" name="description" />
    <meta content="@keenthemes" name="twitter:site" />
    <meta content="@keenthemes" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="Metronic - Tailwind CSS Sign In" name="twitter:title" />
    <meta content="Sign in page, using Tailwind CSS" name="twitter:description" />
    <meta content="assets/media/app/og-image.png" name="twitter:image" />
    <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/authentication/branded/sign-in/index.html"
        property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="@keenthemes" property="og:site_name" />
    <meta content="Metronic - Tailwind CSS Sign In" property="og:title" />
    <meta content="Sign in page, using Tailwind CSS" property="og:description" />
    <meta content="assets/media/app/og-image.png" property="og:image" />
    <link href="assets/media/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="assets/media/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png" />
    <link href="assets/media/app/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png" />
    <link href="{{ asset('assets/media/recom_48*48.ico') }}" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.scss'])
</head>

<body class="antialiased flex h-full text-base text-gray-700 dark:bg-coal-500">
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
    <div class="grid lg:grid-cols-1 grow">
        <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1 page-bg">
            <div class="card max-w-[370px] w-full">
                <form action="{{ route('login') }}" class="card-body flex flex-col gap-5 p-10" id="sign_in_form" method="post">
                    @csrf
                    <div class="text-center mb-2.5">
                        <h3 class="text-lg font-medium text-gray-900 leading-none mb-2.5">
                            Sign in
                        </h3>
                        {{-- <div class="flex items-center justify-center font-medium">
                            <span class="text-2sm text-gray-700 me-1.5">
                                Need an account?
                            </span>
                            <a class="text-2sm link" href="{{ route('register') }}">
                                Sign up
                            </a>
                        </div> --}}
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <label class="form-label font-normal text-gray-900">
                            Email
                        </label>
                        <input class="input {{ $errors->get('email') ? 'border-danger' : '' }}" placeholder="email@email.com" type="email" name="email" value="{{ old('email') }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center justify-between gap-1">
                            <label class="form-label font-normal text-gray-900">
                                Password
                            </label>
                            {{-- <a class="text-2sm link shrink-0"
                                href="javascript:void(0)">
                                Forgot Password?
                            </a> --}}
                        </div>
                        <div class="input" data-toggle-password="true">
                            <input class="{{ $errors->get('password') ? 'border-danger' : '' }}" name="password" placeholder="Enter Password" type="password" required autocomplete="false" />
                            <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                                <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden">
                                </i>
                                <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block">
                                </i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <label class="checkbox-group">
                        <input class="checkbox checkbox-sm" name="remember" type="checkbox" value="1" />
                        <span class="checkbox-label">
                            Remember me
                        </span>
                    </label>
                    <button class="btn btn-primary flex justify-center grow">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
        
    </div>
    <!-- End of Page -->
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    {{-- <script src="assets/js/core.bundle.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js"></script> --}}
    <!-- End of Scripts -->
</body>

</html>
