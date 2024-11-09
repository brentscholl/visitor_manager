@props([
    'type' => 'button',     // Specifies the button type (default is 'button').
    'btn' => 'primary',     // Button style variant (options: 'primary', 'secondary', 'simple', 'danger').
    'loader' => false,      // Indicates whether to show a loading spinner.
    'disabled' => false,    // If true, disables the button.
])

<button
    {{ $attributes->except('class') }}
    type="{{ $type }}"
    {{ $attributes->whereStartsWith('wire:target') }}
    {{ $attributes->whereStartsWith('wire:click') }}

    @if($loader)
        wire:loading.attr="disabled"  {{-- Disable button while loading if loader is true --}}
@endif

@if($disabled)
    disabled  {{-- Static disable if disabled prop is true --}}
@endif

@if($attributes->get('id'))
    id="{{ $attributes->get('id') }}"  {{-- Set button ID if provided in attributes --}}
@endif

class="{{ $attributes->get('class') }} inline-flex items-center px-2.5 py-1.5 space-x-1.5 border text-xs font-semibold uppercase tracking-widest rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2
    @switch($btn)
        @case('primary')
            border-transparent text-white bg-primary-600 hover:bg-primary-700 focus:ring-primary-500
        @break

        @case('secondary')
            border-transparent text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500
        @break

        @case('simple')
            text-primary-400 bg-white hover:bg-indigo-100 focus:ring-indigo-500
        @break

        @case('danger')
            border-transparent text-white bg-red-500 hover:bg-red-700 focus:ring-red-500
        @break
    @endswitch"
>
    {{-- Loading Spinner --}}
    @if($loader)
        <span {{ $attributes->whereStartsWith('wire:target') }} wire:loading>
            <x-svg.spinner class="-ml-1 mr-1.5 h-4 w-4 text-white"/>
        </span>
    @endif

    {{-- Button Content --}}
    {{ $slot }}
</button>
