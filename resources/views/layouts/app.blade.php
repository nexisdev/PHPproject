<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/brands.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/theme.js', 'resources/js/app.js'])

    <script>
        window.settings = @json(\App\Helpers\Cache::allSettings());
    </script>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100 dark:bg-slate-800 dark:text-white">
    <div class="absolute inset-x-0 top-0 z-20 flex justify-center overflow-hidden pointer-events-none">
        <div class="w-[108rem] flex-none flex justify-end">
            <picture>
                <img src="{{ asset('images/cover-1.png') }}" alt=""
                    class="w-[71.75rem] flex-none max-w-none dark:hidden" decoding="async">
            </picture>
            <picture>
                <img src="{{ asset('images/cover-2.png') }}" alt=""
                    class="w-[90rem] flex-none max-w-none hidden dark:block" decoding="async">
            </picture>
        </div>
    </div>
    <div class="min-h-screen">
        @if (auth()->user()->hasRole('Admin'))
            @include('layouts.admin.navbar')
        @else
            @include('layouts.navbar')
        @endif

        <div class="pt-20">
            @if (auth()->user()->hasRole('Admin'))
                @include('layouts.admin.sidebar')
            @else
                @include('layouts.sidebar')
            @endif

            <div class="lg:ml-64">
                <!-- Page Content -->
                <main class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    @isset($scripts)
        {{ $scripts }}
    @endisset
</body>

</html>
