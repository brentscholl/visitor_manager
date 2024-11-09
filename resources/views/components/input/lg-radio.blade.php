@props([
    'uid' => rand(),  // Unique identifier for the radio input
])

<label x-radio-group-option=""
    class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm border-gray-300 undefined focus:outline-none
    hover:bg-secondary-100 focus-within:ring-secondary-200"
    :class="{
        'border-transparent bg-secondary-100': ({{ $attributes->whereStartsWith('x-model')->first() ?: 'value' }} === '{{ $attributes->get('value') }}'),
        'border-gray-300': !({{ $attributes->whereStartsWith('x-model')->first() ?: 'value' }} === '{{ $attributes->get('value') }}'),
        'border-secondary-500 ring-2 ring-secondary-500 bg-secondary-100': (active === '{{ $attributes->get('value') }}'),
        'undefined': !(active === '{{ $attributes->get('value') }}')
    }"
>
    <!-- Hidden Radio Input -->
    <input
        {{ $attributes->whereStartsWith('wire:model') }}
        id="{{ $attributes->whereStartsWith('wire:model')->first() }}-{{ $uid }}"
        type="radio"
        x-model="{{ $attributes->whereStartsWith('x-model')->first() ?: 'value' }}"
        value="{{ $attributes->get('value') }}"
        class="hidden h-4 w-4 mt-0.5 cursor-pointer text-secondary-600 border border-gray-300 focus:ring-secondary-500"
    >

    <!-- Label Content -->
    <span class="flex flex-1">
        {{ $slot }}
    </span>

    <!-- Checkmark Icon for Selected State -->
    <svg class="h-5 w-5 text-secondary-600 invisible"
        :class="{
            'invisible': !({{ $attributes->whereStartsWith('x-model')->first() ?: 'value' }} === '{{ $attributes->get('value') }}'),
            'undefined': ({{ $attributes->whereStartsWith('x-model')->first() ?: 'value' }} === '{{ $attributes->get('value') }}')
        }"
        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
        aria-hidden="true">
        <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
            clip-rule="evenodd"></path>
    </svg>

    <!-- Border Indicator for Active and Checked States -->
    <span class="pointer-events-none absolute -inset-px rounded-lg border-2 border-transparent"
        aria-hidden="true"
        x-description="Active: 'border', Not Active: 'border-2' Checked: 'border-secondary-500', Not Checked: 'border-transparent'"
        :class="{
            'border': (active === '{{ $attributes->get('value') }}'),
            'border-2': !(active === '{{ $attributes->get('value') }}'),
            'border-secondary-500': ({{ $attributes->whereStartsWith('x-model')->first() ?: 'value' }} === '{{ $attributes->get('value') }}'),
            'border-transparent': !({{ $attributes->whereStartsWith('x-model')->first() ?: 'value' }} === '{{ $attributes->get('value') }}')
        }"
    ></span>
</label>
