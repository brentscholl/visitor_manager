@props(['active'])

@php
    /**
     * Determine CSS classes based on the active state of the link.
     * If the link is active, it will display with a blue border and dark text.
     * Otherwise, it shows as a standard link with a gray border and lighter text.
     */
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-blue-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-blue-700 transition duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

    <!-- Navigation Link Component -->
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
