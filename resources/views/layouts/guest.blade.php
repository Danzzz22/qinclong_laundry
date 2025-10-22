<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
         style="background-image: url('{{ asset('images/landscape_login_bg.jpg') }}')">

        <!-- Overlay gelap + blur -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <!-- Slot untuk konten auth (login/register) -->
        <div class="relative w-full max-w-md z-10">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
