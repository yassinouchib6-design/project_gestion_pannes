<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Gestion des pannes') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900">
<div class="min-h-screen">
    @include('layouts.navigation')

    <main class="min-h-[calc(100vh-64px)]">
        {{ $slot }}
    </main>

    <footer class="border-t bg-white/70 py-4 text-center text-sm text-gray-500">
        ©️ {{ date('Y') }} Ministère des Finances — Gestion des pannes
    </footer>
</div>
</body>
</html>