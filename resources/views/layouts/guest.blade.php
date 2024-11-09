<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net"> <!-- Preconnect for faster font loading -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js']) <!-- Load Vite assets for styles and scripts -->

    <!-- Styles for Livewire components -->
    @livewireStyles
</head>
<body>
<div class="font-sans text-gray-900 antialiased">
    {{ $slot }} <!-- Main content slot for guest pages -->
</div>

@livewireScripts <!-- Scripts for Livewire components -->
</body>
</html>
