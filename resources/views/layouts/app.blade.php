<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @stack('styles') <!-- Push additional styles to the stack -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js']) <!-- Load Vite assets -->
    @yield('styles') <!-- Additional styles defined in child views -->

    @stack('scripts.header') <!-- Push additional header scripts -->
    @yield('scripts.header') <!-- Additional header scripts defined in child views -->

    <!-- Styles for Livewire components -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
<livewire:flash-container /> <!-- Livewire flash messages -->
<livewire:tourguide/> <!-- Livewire tour guide component -->

<x-banner /> <!-- Site-wide banner -->

<div class="min-h-screen bg-white">
    @livewire('navigation-menu') <!-- Livewire navigation menu -->

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }} <!-- Dynamic header content -->
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }} <!-- Main content of the page -->
    </main>
</div>

@stack('modals') <!-- Push modals to the stack -->

@yield('scripts.footer') <!-- Additional footer scripts defined in child views -->
@livewireScripts <!-- Scripts for Livewire components -->
</body>
</html>
