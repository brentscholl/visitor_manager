<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
<livewire:flash-container/>
@if($location->team->subscribed() || $location->team->onTrial())
    @livewire('form', ['location' => $location])
@else
    <div class="w-full pt-32 flex justify-center">
        <div class="bg-white shadow sm:rounded-lg w-full max-w-xl border border-red-300">
            <div class="px-4 py-5 sm:p-6 flex flex-col items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Form Unavailable</h3>
                <div class="mt-2 text-sm text-gray-500">
                    <p class="text-center">Access to this form is temporarily restricted. If you are the owner, please log into your account to restore access.</p>
                </div>
            </div>
        </div>
    </div>
@endif
@stack('modals')

@livewireScripts
</body>
</html>
