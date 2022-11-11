<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/theme.js'])
</head>

<body class="relative font-sans antialiased text-gray-900 bg-gray-100 dark:bg-gray-800 dark:text-white">
    <div class="absolute inset-0 z-0 w-full h-full bg-cover"
        style="background-image: url('{{ asset('images/cover.webp') }}')">
        {{-- <img class="object-cover w-full h-full" src="{{  }}" alt="cover"> --}}
    </div>
    <div class="absolute inset-0 z-0 w-full h-full bg-gradient-to-b from-gray-900 via-gray-900 to-gray-900 opacity-60">
    </div>
    <div class="relative z-20">
        {{ $slot }}
    </div>
</body>
</div>

</html>
